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
        Schema::create('post_youtube_urls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')
                  ->constrained()          // posts テーブルを参照
                  ->onDelete('cascade');   // 投稿削除時に連動して削除
            $table->string('youtube_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_youtube_urls');
    }
};
