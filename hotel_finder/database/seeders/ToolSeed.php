<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToolSeed extends Seeder
{

    public function run(): void
    {
        DB::table('tool')->insert([

            'name' => "tv",


        ]);

        DB::table('tool')->insert([

            'name' => "washing machine",


        ]);

        DB::table('tool')->insert([

            'name' => "dryer",


        ]);

        DB::table('tool')->insert([

            'name' => "Wi_Fi",


        ]);

        DB::table('tool')->insert([

            'name' => "dish washer",


        ]);
    }
}
