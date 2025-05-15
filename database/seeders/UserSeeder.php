<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'name' => 'Super admin',
            'email' => 'info.wmnzz@gmail.com',
            'password' => \Hash::make('Admin@1234'),
            'mobile' => '9842999076',
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'otp' => '666666',
            'role_id' => 1
        ]);

         User::create([
            'name' => 'Default Customer',
            'email' => 'defaultcustomer@yopmail.com',
            'password' => \Hash::make('Cus@1234'),
            'mobile' => '7540039846',
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'otp' => '666666',
            'role_id' => 2,
        ]);
    }
}
