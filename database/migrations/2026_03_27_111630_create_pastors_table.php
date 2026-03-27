<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pastors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // posts.pastor_name の既存データを pastors テーブルに移行し、pastor_id カラムを追加
        // 既存の pastor_name データがあれば pastors に登録
        $existingNames = \App\Models\Post::whereNotNull('pastor_name')
            ->where('pastor_name', '!=', '')
            ->pluck('pastor_name')
            ->unique();

        foreach ($existingNames as $name) {
            \App\Models\Pastor::create(['name' => $name]);
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('pastor_id')->nullable()->after('title')->constrained('pastors')->nullOnDelete();
        });

        // 既存データの pastor_name → pastor_id を紐付け
        foreach (\App\Models\Pastor::all() as $pastor) {
            \App\Models\Post::where('pastor_name', $pastor->name)->update(['pastor_id' => $pastor->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pastor_id');
        });

        Schema::dropIfExists('pastors');
    }
};
