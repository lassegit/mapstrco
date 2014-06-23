<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTracksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tracks', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');

			$table->string('url');
			
			$table->float('lat', 15, 11)->index();
			$table->float('lng', 15, 11)->index();

			$table->enum('region', Track::$region)->index()->nullable()->default(null);
			$table->enum('country', Track::$country)->index()->nullable()->default(null);

			$table->enum('genre', Track::$genre)->index()->nullable()->default(null);
			
			$table->integer('user_id')->index()->unsigned()->nullable();

			$table->string('youtubeid')->nullable();
			$table->string('duration')->nullable();
			
			$table->integer('up')->index()->default(0);
			$table->float('hot', 20, 7)->index()->default(0);

			$table->timestamp('deleted_at')->nullable()->index();
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
		Schema::drop('tracks');
	}

}
