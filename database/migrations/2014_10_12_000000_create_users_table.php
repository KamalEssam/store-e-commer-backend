<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('mobile')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();

            $table->boolean('is_active')->default(0);
            $table->boolean('is_notification')->default(1);
            $table->string('pin')->nullable();

            $table->dateTime('last_notification_click')->nullable();
            $table->tinyInteger('role_id')->nullable();
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
