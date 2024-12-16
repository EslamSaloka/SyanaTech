<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarCountryFactoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_country_factories', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        Schema::create('car_country_factory_translations', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('car_id')->unsigned();
            $table->string('locale')->nullable();
            $table->string('name');
            $table->unique(['car_id', 'locale']);
            $table->foreign('car_id')->references('id')->on('car_country_factories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_country_factory_translations');
        Schema::dropIfExists('car_country_factories');
    }
}
