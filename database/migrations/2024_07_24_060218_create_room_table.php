<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('room', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('desc');
            $table->double('price');
            $table->integer('capacity');
            
            $table->foreignId('hotel_id')->constrained('hotel');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('attribute');
    }
};
