<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('clients', function(Blueprint $table) {
			$table->foreign('district_id')->references('id')->on('districts')
						->onDelete('no action')
						->onUpdate('no action');
		});
		Schema::table('districts', function(Blueprint $table) {
			$table->foreign('city_id')->references('id')->on('cities')
						->onDelete('no action')
						->onUpdate('no action');
		});
		Schema::table('meals', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('no action')
						->onUpdate('no action');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('resturant_id')->references('id')->on('restaurants')
						->onDelete('no action')
						->onUpdate('no action');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('client_id')->references('id')->on('clients')
						->onDelete('no action')
						->onUpdate('no action');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('no action')
						->onUpdate('no action');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->foreign('client_id')->references('id')->on('clients')
						->onDelete('no action')
						->onUpdate('no action');
		});
		Schema::table('restaurants', function(Blueprint $table) {
			$table->foreign('district_id')->references('id')->on('districts')
						->onDelete('no action')
						->onUpdate('no action');
		});
		Schema::table('offers', function(Blueprint $table) {
			$table->foreign('restaurant_id')->references('id')->on('restaurants')
						->onDelete('no action')
						->onUpdate('no action');
		});
	}

	public function down()
	{
		Schema::table('clients', function(Blueprint $table) {
			$table->dropForeign('clients_district_id_foreign');
		});
		Schema::table('districts', function(Blueprint $table) {
			$table->dropForeign('districts_city_id_foreign');
		});
		Schema::table('meals', function(Blueprint $table) {
			$table->dropForeign('meals_restaurant_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_resturant_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_client_id_foreign');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->dropForeign('comments_restaurant_id_foreign');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->dropForeign('comments_client_id_foreign');
		});
		Schema::table('restaurants', function(Blueprint $table) {
			$table->dropForeign('restaurants_district_id_foreign');
		});
		Schema::table('offers', function(Blueprint $table) {
			$table->dropForeign('offers_restaurant_id_foreign');
		});
	}
}