<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\HasRole;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->createUser();
        $this->createRole();
        $this->modelHasRole();
    }

    public function createUser(){
        User::insert([
            [
                'name' => "Khenneth",
                'email' => "khenneth.alaiza@gmail.com",
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'api_token' => Str::random(60),
                'remember_token' => Str::random(10),
            ]
        ]);
    }

    public function createRole(){
        Role::insert([
            [
                'name' => "Administrator",
                'guard_name' => "web",
                'description' => 'Super Admin',
            ]
        ]);
    }

    public function modelHasRole(){
        HasRole::insert([
            [
                'role_id' => 1,
                'model_type' => "App\Models\User",
                'model_id' => 1
            ]
        ]);
    }
}
