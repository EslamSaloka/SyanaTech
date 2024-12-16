<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        Schema::create('color_translations', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('color_id')->unsigned();
            $table->string('locale')->nullable();
            $table->string('name');
            $table->unique(['color_id', 'locale']);
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('color_translations');
        Schema::dropIfExists('colors');
    }
}
