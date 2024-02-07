<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->double('monthly_price')->nullable();
            $table->string('sub_categories')->nullable();
            $table->string('extendable_price')->nullable();
            // $table->double('six_month_price')->nullable();
            // $table->double('twelve_month_price')->nullable();
            $table->boolean('mobile_availability')->default(1);
            $table->boolean('description_availability')->default(1);
            $table->integer('service_count')->nullable();
            $table->integer('position')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('membership_packages');
    }
}
