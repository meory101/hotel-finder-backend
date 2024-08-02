<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('image', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->foreignId('room_id')->constrained('room');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('image');
    }
};
