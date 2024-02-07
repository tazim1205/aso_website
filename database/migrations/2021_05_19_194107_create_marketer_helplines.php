<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketerHelplines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketer_helplines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('controller_id');
            $table->foreignId('district_id');
            $table->foreignId('upazila_id');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('marketer_helplines');
    }
}
