<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\UserRole;
use Exception;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (UserRole::count() === 0) {
            $userRole = new UserRole();
            $userRole->name = 'SuperAdmin';
            $userRole->permissions = '[]';
            $userRole->column_permissions = '[]';
            $userRole->save();
        }
    }
}
