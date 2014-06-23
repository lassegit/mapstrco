<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 50);
			$table->string('title', 30);
			$table->text('body');
			$table->string('mail')->unique();
			$table->string('password');
			$table->string('image')->nullable()->default(null);
			$table->enum('gender', User::$gender)->nullable()->default(null);
			$table->enum('region', User::$region)->index()->nullable()->default(null);
			$table->enum('country', User::$country)->index()->nullable()->default(null);
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
		Schema::drop('users');
	}

}
