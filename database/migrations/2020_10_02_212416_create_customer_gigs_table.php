<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerGigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_gigs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->string('title');
            $table->text('description');
            $table->string('address');
            $table->foreignId('service_id');
            $table->string('day');
            $table->double('budget');
            $table->string('status')->default('active')->comment('active|running|complete|cancelled');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('customer_gigs');
    }
}
