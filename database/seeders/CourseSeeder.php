<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            'organization_id'=>1,
            'title'=>'First course 1',
            'learn'=>'
                <ul>
                <li>Principles of 2D and 3D graphics, animation, sound, and collision detection</li>
                <li>Unity and Love 2D</li>
                <li>Lua, C#</li>
                <li>Basics of game design and development</li>
                </ul>
            ',
            'brief'=>'Brief introduction',
            'description'=>'<p>description</p><p>https://pll.harvard.edu/course/cs50s-introduction-game-development</p>',
            'published'=>true,
            'user_id'=>1
        ]);

    }
}
