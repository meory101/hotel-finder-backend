<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeed extends Seeder
{

    public function run(): void
    {


        DB::table('attribute')->insert([

            'name' => "type1",
            'desc' => "this is type1",
            'price' => 100,
            'capacity' => 1

        ]);

        DB::table('attribute')->insert([

            'name' => "type1",
            'desc' => "this is type1",
            'price' => 100,
            'capacity' => 1

        ]);

        DB::table('attribute')->insert([

            'name' => "type2",
            'desc' => "this is type2",
            'price' => 200,
            'capacity' => 2

        ]);

        DB::table('attribute')->insert([

            'name' => "type3",
            'desc' => "this is type3",
            'price' => 300,
            'capacity' => 3

        ]);

        DB::table('attribute')->insert([

            'name' => "type4",
            'desc' => "this is type4",
            'price' => 400,
            'capacity' => 4

        ]);
    }
}
