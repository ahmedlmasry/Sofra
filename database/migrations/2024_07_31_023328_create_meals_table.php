<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMealsTable extends Migration {

	public function up()
	{
		Schema::create('meals', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->text('description');
			$table->decimal('price');
			$table->decimal('offer_price');
			$table->integer('restaurant_id')->unsigned();
			$table->string('image');
			$table->string('meal_time');
		});
	}

	public function down()
	{
		Schema::drop('meals');
	}
}
