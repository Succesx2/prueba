<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->integer('airline_id');
            $table->date('airport_exit');
            $table->date('airport_entrance');
            $table->integer('max_seats')->default(5);
            $table->integer('reserved_seats')->default(0);
            $table->string('code');
            $table->integer('airport_id');
            $table->integer('airplane_id');
            $table->boolean('is_delete')->default(false);
            $table->boolean('is_full')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
