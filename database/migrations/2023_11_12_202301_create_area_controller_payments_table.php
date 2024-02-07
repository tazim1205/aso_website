<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaControllerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_controller_payments', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->string('upazila');
            $table->decimal('amount')->default(0);
            $table->date('paid_date');
            $table->string('controller_ac_number');
            $table->string('controller_ac_details')->nullable();
            $table->string('company_ac_number')->nullable();
            $table->string('company_ac_details')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['pending', 'paid']);
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
        Schema::dropIfExists('area_controller_payments');
    }
}
