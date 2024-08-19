<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDistrictsTable extends Migration {

	public function up()
	{
		Schema::create('districts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('city_id')->unsigned();
			$table->string('name');
		});
	}

	public function down()
	{
		Schema::drop('districts');
	}
}