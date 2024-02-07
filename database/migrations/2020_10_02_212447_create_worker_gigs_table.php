<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerGigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_gigs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id');
            $table->foreignId('service_id');
            $table->string('title');
            $table->text('description');
            $table->string('tags')->nullable();
            $table->double('budget');
            $table->string('day');
            $table->integer('click')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('worker_gigs');
    }
}
