<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->integer('district_id')->unsigned();
			$table->string('image');
			$table->string('pin_code')->nullable();
			$table->boolean('status');
            $table->string('api_token',60)->unique()->nullable();

        });
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
