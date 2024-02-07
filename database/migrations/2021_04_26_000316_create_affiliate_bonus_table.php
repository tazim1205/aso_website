<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_user_id');
            $table->foreignId('user_id');
            $table->double('amount');
            $table->string('month');
            $table->string('year');
            $table->string('bonus_purpose')->nullable()->comment('Target Filup|Order commission|Worker Signup|Membership Signup|Marketer commission');
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
        Schema::dropIfExists('affiliate_bonuses');
    }
}
