<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dues', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provider_id')->nullable();
            $table->float('total')->default(0);
            $table->boolean('accept')->default(0); // 0 => new || 1 => accepted || 2 => rejected
            $table->boolean('reject')->default(0); // 0 => new || 1 => accepted || 2 => rejected
            $table->timestamps();
        });

        Schema::create('dues_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dues_id')->nullable();
            $table->bigInteger('order_id')->nullable();
            $table->float('order_total')->default(0);
            $table->float('order_dues')->default(0);
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
        Schema::dropIfExists('dues');
        Schema::dropIfExists('dues_items');
    }
}
