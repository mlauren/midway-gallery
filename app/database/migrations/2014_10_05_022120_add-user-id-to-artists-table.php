<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToArtistsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('artists', function($table)
		{
		    $table->integer('user_id');
		    $table->string('permalink');
		    $table->boolean('affiliate');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('artists', function($table)
		{
		    $table->dropColumn('user_id');
		    $table->dropColumn('permalink');
		    $table->dropColumn('affiliate');
		});
	}

}
