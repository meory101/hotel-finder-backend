<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeViewSeed extends Seeder
{

    public function run(): void
    {
        DB::table('attribute_view')->insert([

            'att_id' => 1,
            'view_id' => 2,
        ]);
        DB::table('attribute_view')->insert([

            'att_id' => 2,
            'view_id' => 1,
        ]);
        DB::table('attribute_view')->insert([

            'att_id' => 4,
            'view_id' => 5,
        ]);

        DB::table('attribute_view')->insert([

            'att_id' => 3,
            'view_id' => 4,
        ]);
        DB::table('attribute_view')->insert([

            'att_id' => 5,
            'view_id' => 5,
        ]);
    }
}
