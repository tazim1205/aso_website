<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_gig_id')->nullable();
            $table->foreignId('worker_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->string('status')->default('active')->comment('active|complete|running|cancelled');
            $table->double('budget')->nullable();
            $table->double('proposed_budget')->nullable();
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('gig_refferral_code')->nullable();
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
        Schema::dropIfExists('customer_bids');
    }
}
