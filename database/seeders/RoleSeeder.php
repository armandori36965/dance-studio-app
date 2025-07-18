<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // 記得引用 Role Model

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'Admin']); // id 會是 1
        Role::create(['name' => 'Teacher']); // id 會是 2
        Role::create(['name' => 'Parent']); // id 會是 3
        Role::create(['name' => 'SchoolAdmin']); // id 會是 4
    }
}