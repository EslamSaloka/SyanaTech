<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('know_us', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        Schema::create('know_us_translations', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('know_us_id')->unsigned();
            $table->string('locale')->nullable();
            $table->string('name');
            $table->unique(['know_us_id', 'locale']);
            $table->foreign('know_us_id')->references('id')->on('know_us')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('know_us_translations');
        Schema::dropIfExists('know_us');
    }
}
