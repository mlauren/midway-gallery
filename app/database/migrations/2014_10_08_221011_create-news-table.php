<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news', function($table)
		{
			$table->increments('id');
			$table->string('title', 50)->unique();
			$table->integer('user_id');
			$table->string('url', 1000);
			$table->string('cover_image', 1000);
			$table->string('description', 3000);
			$table->string('permalink', 55);
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
		Schema::drop('news');
	}

}
