<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppIntrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intros', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('intro_translations', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('intro_id')->unsigned();
            $table->string('locale')->nullable();
            $table->string('description');
            $table->unique(['intro_id', 'locale']);
            $table->foreign('intro_id')->references('id')->on('intros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intro_translations');
        Schema::dropIfExists('intros');
    }
}
