<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_complains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complainer_id')->comment('user id');
            $table->foreignId('service_bid_id')->nullable();
            $table->text('complain')->nullable();
            $table->boolean('is_completed')->default(0);
            $table->foreignId('completed_by_id')->nullable();
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
        Schema::dropIfExists('service_complains');
    }
}
