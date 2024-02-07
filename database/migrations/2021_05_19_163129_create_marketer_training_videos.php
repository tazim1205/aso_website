<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketerTrainingVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketer_training_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('controller_id');
            $table->foreignId('district_id');
            $table->foreignId('upazila_id');
            $table->text('link')->nullable();
            $table->string('title')->nullable();
            $table->boolean('status')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('marketer_training_videos');
    }
}
