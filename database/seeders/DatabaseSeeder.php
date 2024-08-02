<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Attribute;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $this->call([
            AttributeSeed::class,
            ViewSeed::class,
            ToolSeed::class,
            AttributeViewSeed::class,
            AttributeToolSeed::class,

        ]);
    }
}
