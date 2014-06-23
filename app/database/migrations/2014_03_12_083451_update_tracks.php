<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTracks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tracks', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `tracks` MODIFY genre varchar(50) DEFAULT NULL');

			DB::statement('ALTER TABLE `tracks` MODIFY region varchar(50) DEFAULT NULL');

			DB::statement('ALTER TABLE `tracks` MODIFY country varchar(50) DEFAULT NULL');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tracks', function(Blueprint $table)
		{
			//
		});
	}

}