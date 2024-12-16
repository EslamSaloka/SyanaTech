<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // IDS
            $table->bigInteger("customer_id");
            $table->bigInteger("car_id");
            $table->bigInteger("car_country_factory_id")->nullable();
            $table->bigInteger("category_id");
            $table->bigInteger("provider_id")->nullable();
            // ===== //
            $table->string("customer_name")->nullable();
            // ADDRESS //
            $table->string("address_name")->nullable();
            $table->longText("location_name")->nullable();
            $table->string("lat")->nullable();
            $table->string("lng")->nullable();
            $table->bigInteger("region_id")->nullable();
            $table->bigInteger("city_id")->nullable();
            // ADDRESS //
            $table->string("order_place")->default("in-location"); //in-location || in-center
            // More Information //
            $table->longText("description")->nullable();
            // Order Status //
            $table->string("order_status")->default("new"); // new || in process || wait for pay || done || close
            $table->string("close_by")->nullable();
            $table->bigInteger("close_by_id")->nullable();
            $table->string("close_message")->nullable();
            // Price //
            $table->float("sub_total")->default(0);
            $table->float("vat")->default(0);
            $table->float("total")->default(0);
            $table->boolean("dues")->default(1);
            $table->timestamp("process_at")->nullable();
            $table->timestamp("cancel_at")->nullable();
            $table->timestamp("completed_at")->nullable();
            $table->boolean("rate")->default(0);
            $table->timestamps();
        });

        Schema::create('order_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("order_id");
            $table->string("image")->nullable();
            $table->timestamps();
        });

        Schema::create('order_providers_answer', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("order_id");
            $table->bigInteger("provider_id");
            $table->longText("answer")->nullable();
            $table->boolean("accept")->default(0);

            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("order_id");
            $table->longText("name");
            $table->float("price");

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
        Schema::dropIfExists('order_images');
        Schema::dropIfExists('order_providers_answer');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
}
