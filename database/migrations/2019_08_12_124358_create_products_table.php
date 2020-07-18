<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('article');
            $table->integer('category');
            $table->text('description');
            $table->string('img_path');
            $table->string('manufacturer');
            $table->integer('available');
            $table->string('unit');
            $table->float('in_package');
            $table->string('additional');
            $table->string('buy_with');
            $table->string('similar');
            $table->boolean('bestseller');
            $table->boolean('sel_lout');
            $table->boolean('new');
            $table->string('delivery');
            $table->string('pickup');
            $table->integer('price');
            $table->integer('old_price');
            $table->json('comments');
            $table->string('rate');
            $table->string('video');
            $table->boolean('is_active');
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
        Schema::dropIfExists('products');
    }
}
