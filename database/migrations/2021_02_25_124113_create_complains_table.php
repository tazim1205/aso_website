<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complainer_id')->comment('user id');
            $table->foreignId('purpose_id')->nullable()->comment('git | bid id');
            $table->string('purpose_type')->nullable()->comment('customer gig|customer bid,worker gig|worker bid');
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
        Schema::dropIfExists('complains');
    }
}
