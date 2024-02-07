<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_profiles', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('special_service_id');
            $table->foreignId('controller_id')->comment('who add');
            $table->foreignId('upazila_id');
            $table->string('name');
            $table->string('phone');
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_free')->comment('is he available for job ?')->default(1);
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
        Schema::dropIfExists('special_profiles');
    }
}
