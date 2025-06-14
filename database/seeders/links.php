<?php

namespace Database\Seeders;
use App\Models\Link;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class links extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Link::factory(100)->create([
            'postby'=>'1']);
    }
}
