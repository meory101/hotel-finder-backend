<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeToolSeed extends Seeder
{
   
    public function run(): void
    {
        DB::table('attribute_tool')->insert([

            'att_id' => 1,
            'tool_id' => 2,
        ]);
        DB::table('attribute_tool')->insert([

            'att_id' => 2,
            'tool_id' => 1,
        ]);
        DB::table('attribute_tool')->insert([

            'att_id' => 4,
            'tool_id' => 5,
        ]);

        DB::table('attribute_tool')->insert([

            'att_id' => 3,
            'tool_id' => 4,
        ]);
        DB::table('attribute_tool')->insert([

            'att_id' => 5,
            'tool_id' => 5,
        ]);
    }
}
