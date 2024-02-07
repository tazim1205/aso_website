<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_gig_id');
            $table->foreignId('worker_id');
            $table->double('budget');
            $table->text('description');
            $table->string('gig_refferral_code')->nullable();
            $table->boolean('is_selected')->default(0);
            $table->boolean('is_cancelled')->default(0);
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
        Schema::dropIfExists('worker_bids');
    }
}
