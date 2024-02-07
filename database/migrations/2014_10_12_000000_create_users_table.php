<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(1)->comment('1-Active');
            $table->string('full_name');
            $table->string('user_name')->unique();
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->string('gender')->nullable()->comment('male|female');
            $table->foreignId('upazila_id')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->string('pouroshova_union_id')->nullable();
            $table->string('word_road_id')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('worker_service')->nullable();
            $table->string('role')->default('customer')->comment('admin|controller|worker|membership|customer');
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_logout_at')->nullable();
            $table->string('password');
            $table->string('temp_otp')->nullable();
            $table->string('reset_date')->nullable()->comment('Password reset code sending date');
            $table->integer('reset_count')->nullable()->comment('In a day how many time reset message available');
            $table->string('number')->unique()->nullable()->comment('Identity card number');
            $table->string('front_image')->nullable();
            $table->string('back_image')->nullable();
            $table->string('address')->nullable();
            $table->integer('referred_by')->nullable();
            $table->integer('referral_code')->nullable();
            $table->integer('out_of_work')->default(0);
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
