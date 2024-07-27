<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('room_tool', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('room');
            $table->foreignId('tool_id')->constrained('tool');
            $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('attribute_tool');
    }
};
