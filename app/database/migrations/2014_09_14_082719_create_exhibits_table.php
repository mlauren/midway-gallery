<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExhibitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('exhibits', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('title');
			$table->string('details');
			$table->string('video');
			$table->string('media');
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
		Schema::drop('exhibits');
	}

}
