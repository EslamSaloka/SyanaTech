<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('content_translations', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('content_id')->unsigned();
            $table->string('locale')->nullable();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->unique(['content_id', 'locale']);
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_translations');
        Schema::dropIfExists('contents');
    }
}
