<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateImageIdsToUseInteger extends Migration {

	public function up()
	{
		DB::update('alter table artists modify inside_image int');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    DB::update('alter table artists modify inside_image varchar(700)');
	}

}
