<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('TracksTableSeeder');
		$this->call('CommentsTableSeeder');
		$this->call('LikesTableSeeder');
		$this->call('UsersTableSeeder');
	}

}