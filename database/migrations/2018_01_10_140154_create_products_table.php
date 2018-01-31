<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->integer('weight');
        $table->integer('price');
        $table->text('composition');
        $table->integer('category_id')->unsigned()->index();
        $table->binary('pictures');

        $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('products');
    }
}
