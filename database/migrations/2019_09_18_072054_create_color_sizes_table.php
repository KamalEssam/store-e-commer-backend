<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_sizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->timestamps();
        });

        Schema::table('color_sizes', function (Blueprint $table) {
            $table->foreign('variant_id')
                ->references('id')
                ->on('product_colors')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });


        Schema::table('color_sizes', function (Blueprint $table) {
            $table->foreign('size_id')
                ->references('id')
                ->on('sizes')
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
        Schema::dropIfExists('color_sizes');
    }
}
