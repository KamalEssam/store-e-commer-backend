<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->double('lat')->default(0);
            $table->double('lng')->default(0);
            $table->enum('type', ['home', 'work', 'others'])->default('home');
            $table->string('street_name')->nullable();
            $table->string('building_no')->nullable();
            $table->string('apartment_no')->nullable();
            $table->string('floor_no')->nullable();
            $table->string('additional')->nullable();

            $table->timestamps();
        });

        Schema::table('user_addresses', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
