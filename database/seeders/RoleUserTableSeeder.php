<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 追加
        // Adminユーザーの作成または取得
        $adminUser = User::firstOrCreate(

            ['email' => 'admin@test'], // 一意となる条件

            [
                'name'     => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );


        // Regularユーザーの作成または取得
        $regularUser = User::firstOrCreate(
            ['email' => 'test@test'],
            [
                'name'     => 'Regular User',
                'password' => bcrypt('password'),
            ]

        );


        // Adminユーザーにadminロールのみ（id:1）を付与
        $adminUser->roles()->attach(1);

        // Regularユーザーにuserロールのみ（id:2）を付与
        $regularUser->roles()->attach(2);
    }
}
