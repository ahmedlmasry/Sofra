<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->integer('district_id')->unsigned();
			$table->string('contact_whats');
			$table->string('image');
			$table->string('pin_code')->nullable();
			$table->string('contact_phone');
			$table->decimal('minimum_order');
			$table->decimal('delivery_charge');
			$table->boolean('status');
            $table->string('api_token',60)->unique()->nullable();

        });
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}
