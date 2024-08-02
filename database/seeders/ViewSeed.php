<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViewSeed extends Seeder
{
    public function run(): void
    {

        DB::table('view')->insert([

            'name' => "sea",
            

        ]);

        DB::table('view')->insert([

            'name' => "mountain",
        

        ]);

        DB::table('view')->insert([

            'name' => "river",
     

        ]);

        DB::table('view')->insert([

            'name' => "pool",
    

        ]);

        DB::table('view')->insert([

            'name' => "garden",
        

        ]);
    }
}
