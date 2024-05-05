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
            $table->string('doctor_id')->nullable();
            $table->string('nurse_id')->nullable();
            $table->string('weekday')->nullable();
            $table->integer('start_hour')->nullable();
            $table->integer('start_minute')->nullable();
            $table->integer('end_hour')->nullable();
            $table->integer('end_minute')->nullable();
            $table->enum('shift', ['Pagi', 'Siang', 'Malam'])->nullable();
            $table->timestamps();

            $table->foreign('doctor_id')->references('doctor_id')->on('doctors')->onDelete('cascade');
            $table->foreign('nurse_id')->references('nurse_id')->on('nurses')->onDelete('cascade');
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
