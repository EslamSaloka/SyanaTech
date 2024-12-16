<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerCarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("customer_id");
            $table->bigInteger("color_id")->nullable();
            $table->bigInteger("car_country_factory_id")->nullable();
            $table->string("vin")->nullable();
            $table->string("vds")->nullable();
            $table->string("region")->nullable();
            $table->string("country")->nullable();
            $table->string("manufacturer")->nullable();
            $table->string("modelYear")->nullable();
            $table->longText("data")->nullable();
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
        Schema::dropIfExists('cars');
    }
}
