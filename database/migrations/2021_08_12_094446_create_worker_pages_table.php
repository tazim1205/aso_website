<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->nullable();
            $table->foreignId('membership_id')->nullable();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->longText('description', 2000)->nullable();
            $table->longText('address')->nullable();
            $table->string('services')->nullable();
            $table->string('worker_services')->nullable();
            $table->string('phone')->nullable();
            $table->string('location', 1000)->nullable();
            $table->integer('click')->default(0)->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->string('visibility', 20)->default('show')->nullable();
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
        Schema::dropIfExists('worker_pages');
    }
}
