<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProviderStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_provider_stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); 
            $table->foreignId('category_id')->nullable(); 
            $table->foreignId('service_id')->nullable(); 
            $table->foreignId('gig_id')->nullable(); 
            $table->foreignId('page_id')->nullable(); 
            $table->string('image')->nullable(); 
            $table->text('text')->nullable(); 
            $table->text('viewBy')->nullable(); 
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
        Schema::dropIfExists('service_provider_stories');
    }
}
