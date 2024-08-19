<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMealOrderTable extends Migration {

	public function up()
	{
		Schema::create('meal_order', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('meal_id');
			$table->integer('order_id');
			$table->decimal('price');
			$table->string('quality');
			$table->text('special_note');
		});
	}

	public function down()
	{
		Schema::drop('meal_order');
	}
}