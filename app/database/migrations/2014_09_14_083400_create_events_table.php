<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('title');
			$table->string('details');
			$table->string('permalink');
			$table->string('social');
			$table->string('address_title');
			$table->string('address');
			$table->string('media');
			$table->string('exhibit_id');
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
		//
	}

}
