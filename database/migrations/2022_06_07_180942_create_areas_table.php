<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent')->default(0);
            $table->timestamps();
        });

        Schema::create('area_translations', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('area_id')->unsigned();
            $table->string('locale')->nullable();
            $table->string('name');
            $table->unique(['area_id', 'locale']);
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_translations');
        Schema::dropIfExists('areas');
    }
}
