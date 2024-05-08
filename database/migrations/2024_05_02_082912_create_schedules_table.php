<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('cascade');
            $table->foreignId('nurse_id')->nullable()->constrained('nurses')->onDelete('cascade');
            $table->string('weekday')->nullable();
            $table->integer('start_hour')->nullable();
            $table->integer('start_minute')->nullable();
            $table->integer('end_hour')->nullable();
            $table->integer('end_minute')->nullable();
            $table->enum('shift', ['Pagi', 'Siang', 'Malam'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
