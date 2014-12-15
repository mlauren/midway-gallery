<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToSlides extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('media', function($table)
		{
		    $table->integer('slide_id')->unsigned();
			$table->foreign('slide_id')->references('id')->on('slides');
		});	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('media', function($table)
		{
			$table->foreign('slide_id')
		      ->references('id')->on('slides')
		      ->onDelete('cascade');
      	});
	}

}
