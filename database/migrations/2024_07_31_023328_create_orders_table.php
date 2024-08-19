<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('restaurant_id')->unsigned();
			$table->enum('payment_method', array('cash', 'visa'));
			$table->text('note');
			$table->decimal('total_price');
			$table->enum('state', array('pending', 'accepted', 'rejected', 'declined', 'delivered'));
			$table->integer('client_id')->unsigned();
			$table->text('address');
			$table->decimal('delivery_charge');
			$table->decimal('commission');
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
