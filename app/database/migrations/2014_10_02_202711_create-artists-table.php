<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('artists', function($table)
		{
			$table->increments('id');
			$table->string('name', 50)->unique();
			$table->string('cover_image', 1000);
			$table->string('credentials', 500);
			$table->string('description', 1000);
			$table->string('inside_image', 1000);
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
		Schema::drop('artists');
	}

}
