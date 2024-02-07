<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->default('default.png');
            $table->foreignId('category_id');
            $table->double('comission_rate')->nullable();
            $table->double('marketer_comission')->nullable();
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
        Schema::dropIfExists('membership_services');
    }
}
