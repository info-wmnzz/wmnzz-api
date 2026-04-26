<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Role;
use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roles = [
            [
                'role_name'        => 'Super Admin',
                'role_slug'        => 'super_admin',
                'role_description' => 'Full system access',
                'status'           => 1,
            ],
            [
                'role_name'        => 'Seller',
                'role_slug'        => 'seller',
                'role_description' => 'Can manage and sell products',
                'status'           => 1,
            ],
            [
                'role_name'        => 'Service Provider',
                'role_slug'        => 'service_provider',
                'role_description' => 'Provides services to customers',
                'status'           => 1,
            ],
            [
                'role_name'        => 'Customer',
                'role_slug'        => 'customer',
                'role_description' => 'Regular platform user',
                'status'           => 1,
            ],
        ];

        Role::insert($roles);
    }
}
