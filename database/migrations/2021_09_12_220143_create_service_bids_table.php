<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_service_id');
            $table->foreignId('worker_id');
            $table->foreignId('customer_id');
            $table->string('status')->default('active')->comment('active|complete|running|cancelled');
            $table->double('budget');
            $table->double('proposed_budget')->nullable();
            $table->text('description');
            $table->string('address');
            $table->timestamp('completed_at');
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
        Schema::dropIfExists('service_bids');
    }
}
