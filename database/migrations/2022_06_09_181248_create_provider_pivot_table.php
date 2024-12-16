<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_categories_pivot', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("provider_id");
            $table->bigInteger("category_id");
            $table->timestamps();
        });

        Schema::create('provider_car_factories_pivot', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("provider_id");
            $table->bigInteger("car_id");
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
        Schema::dropIfExists('provider_categories_pivot');
        Schema::dropIfExists('provider_car_factories_pivot');
    }
}
