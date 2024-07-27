<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('user_room', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('file')->nullable();
            $table->enum('type', [0,1,2])->default(0);
            $table->foreignId('room_id')->constrained('room');
            $table->foreignId('user_id')->constrained('user');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('user_att');
    }
};
