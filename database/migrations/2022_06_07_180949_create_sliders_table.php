<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provider_id');
            $table->string('image')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        Schema::create('slider_translations', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('slider_id')->unsigned();
            $table->string('locale')->nullable();
            $table->string('name');
            $table->unique(['slider_id', 'locale']);
            $table->foreign('slider_id')->references('id')->on('sliders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slider_translations');
        Schema::dropIfExists('sliders');
    }
}
