<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TurnExIdInEventsTableIntoInt extends Migration {

	public function up()
	{
		DB::update('alter table events modify exhibit_id int');
	}

	public function down()
	{
		DB::update('alter table events modify exhibit_id varchar(700)');
	}

}
