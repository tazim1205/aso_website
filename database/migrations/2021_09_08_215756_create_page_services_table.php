<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id');
            $table->foreignId('service_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('tags')->nullable();
            $table->double('budget');
            $table->string('day');
            $table->integer('click')->default(0);
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_services');
    }
}
