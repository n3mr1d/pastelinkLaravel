<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Link;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Link::factory(100)->create([
            'postby'=>'1']);
        // User::factory()->create([
        //     'username' => 'danwin',
        //     'email' => 'test@example.com',
        //     'password'=>'password',
        //     'is_admin'=>'1'
        // ]);
    }
}
