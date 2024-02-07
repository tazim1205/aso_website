<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipServiceProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_service_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->comment('user-id');
            $table->foreignId('membership_id')->nullable();
            $table->foreignId('membership_service_id')->nullable();
            $table->string('logo')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('address')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->string('image5')->nullable();
            $table->string('image6')->nullable();
            $table->string('image7')->nullable();
            $table->string('image8')->nullable();
            $table->string('image9')->nullable();
            $table->string('image10')->nullable();
            $table->string('image11')->nullable();
            $table->string('image12')->nullable();
            $table->string('image13')->nullable();
            $table->string('image14')->nullable();
            $table->string('image15')->nullable();
            $table->integer('position')->nullable()->comment('members package position');
            $table->foreignId('upazila_id')->nullable()->comment('members upazila id');
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
        Schema::dropIfExists('membership_service_profiles');
    }
}
