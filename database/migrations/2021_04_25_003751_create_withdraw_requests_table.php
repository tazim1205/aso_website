<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unsigned();
            $table->double('amount');
            $table->string('via');
            $table->string('ac_number')->nullable();
            $table->string('ac_details')->nullable(); 
            $table->string('paid_via')->nullable(); 
            $table->string('cac_number')->nullable(); 
            $table->string('cac_details')->nullable(); 
            $table->string('transaction_id')->nullable(); 
            $table->text('cancel_reason')->nullable(); 
            $table->string('status')->nullable(); 
            $table->string('paid_amount')->nullable(); 
            $table->dateTime('paid_date')->nullable(); 
            $table->dateTime('cancel_date')->nullable(); 
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
        Schema::dropIfExists('withdraw_requests');
    }
}
