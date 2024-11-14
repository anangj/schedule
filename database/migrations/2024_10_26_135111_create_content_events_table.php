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
        Schema::create('content_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_event_id');
            $table->enum('type', ['video', 'image']);
            $table->string('url');
            $table->string('filename');
            $table->json('metadata');
            $table->foreign('master_event_id')->references('id')->on('master_events')->onDelete('cascade');
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
        Schema::dropIfExists('content_events');
    }
};
