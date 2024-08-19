<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->decimal('commission');
			$table->text('play_store_link');
			$table->text('app_store_link');
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}
