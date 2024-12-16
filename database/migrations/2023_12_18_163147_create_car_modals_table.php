<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarModalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_modals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->default(0);
            $table->timestamps();
        });

        Schema::create('car_modal_translations', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('car_modal_id')->unsigned();
            $table->string('locale')->nullable();
            $table->string('name');
            $table->unique(['car_modal_id', 'locale']);
            $table->foreign('car_modal_id')->references('id')->on('car_modals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_modal_translations');
        Schema::dropIfExists('car_modals');
    }
}
