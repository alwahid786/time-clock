<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('superadmin'),
            'remember_token' => null,
            'created_at' => '2024-03-25 00:04:40',
            'updated_at' => '2024-03-26 00:36:45',
            'user_type' => 'super-admin',
            'phone' => '1234567890',
            'admin_id' => 1,
            'otp' => '6999',
            'profile_img' => null,
        ]);
    }
}
