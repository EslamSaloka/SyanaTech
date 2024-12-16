<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->timestamp("phone_verified_at")->nullable();
            $table->string('password')->nullable();
            $table->string('api_token')->nullable();
            $table->string('devices_token')->nullable();
            $table->string('avatar')->nullable();
            $table->string('user_type')->default('admin'); // admin || customer || provider
            // =====================================  //
            // =========== Provider Data ===========  //
            // =====================================  //
            $table->string('provider_name')->nullable();
            $table->string('commercial_registration_number')->nullable();
            $table->string('tax_number')->nullable();
            // =========== Shard ===========  //
            $table->bigInteger('region')->nullable();
            $table->bigInteger('city')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            // ======================================= //
            $table->string('how_to_know_us')->default("other");
            $table->longText('terms')->nullable();
            $table->float('rates')->nullable();
            $table->float('otp')->nullable();
            // =====================================  //
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
