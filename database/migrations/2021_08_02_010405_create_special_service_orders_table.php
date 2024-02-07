<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_service_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->comment('who add');
            $table->foreignId('upazila_id')->nullable();
            $table->foreignId('service_id')->nullable();
            $table->longText('description')->nullable();
            $table->string('address')->nullable();
            $table->string('transaction_no')->nullable();
            $table->double('fee')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('special_service_orders');
    }
}
