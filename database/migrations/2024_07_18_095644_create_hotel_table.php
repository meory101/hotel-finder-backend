<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('hotel', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('email');
            $table->string('password');
            $table->double('lat');
            $table->double('long');
            $table->string('location_desc');
            $table->string('desc');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('hotel');
    }
};
