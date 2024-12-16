<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('account_number')->nullable();
            $table->string('iban')->nullable();
            $table->timestamps();
        });
        
        Schema::create('bank_translations', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('bank_id')->unsigned();
            $table->string('locale')->nullable();
            $table->string('bank_name');
            $table->string('account_name')->nullable();
            $table->unique(['bank_id', 'locale']);
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_translations');
        Schema::dropIfExists('banks');
    }
}
