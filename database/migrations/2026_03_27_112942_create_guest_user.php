<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ゲスト用ロールを作成
        DB::table('roles')->insert([
            'name' => 'guest',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $guestRoleId = DB::table('roles')->where('name', 'guest')->value('id');

        // ゲストユーザーを作成
        $guestUserId = DB::table('users')->insertGetId([
            'name' => 'ゲスト',
            'email' => 'guest@ichihara-church.local',
            'password' => Hash::make(\Illuminate\Support\Str::random(64)),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ゲストロールを紐付け
        DB::table('role_user')->insert([
            'user_id' => $guestUserId,
            'role_id' => $guestRoleId,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $guestUser = DB::table('users')->where('email', 'guest@ichihara-church.local')->first();
        if ($guestUser) {
            DB::table('role_user')->where('user_id', $guestUser->id)->delete();
            DB::table('users')->where('id', $guestUser->id)->delete();
        }
        DB::table('roles')->where('name', 'guest')->delete();
    }
};
