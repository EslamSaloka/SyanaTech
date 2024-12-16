<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefusalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refusals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent')->default(0);
            $table->timestamps();
        });

        Schema::create('refusal_translations', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('refusal_id')->unsigned();
            $table->string('locale')->nullable();
            $table->string('name');
            $table->unique(['refusal_id', 'locale']);
            $table->foreign('refusal_id')->references('id')->on('refusals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refusal_translations');
        Schema::dropIfExists('refusals');
    }
}
