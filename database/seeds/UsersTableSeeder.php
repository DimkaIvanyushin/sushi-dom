<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'phone' => '111111111',
            'password' => bcrypt('123456'),
        ]);

        $owner = new Role();
		$owner->name         = 'user';
		$owner->display_name = 'Пользователь'; // optional
		$owner->description  = 'Пользователь магазина'; // optional
		$owner->save();

		$admin = new Role();
		$admin->name         = 'admin';
		$admin->display_name = 'Администратор'; // optional
		$admin->description  = 'Администратор магазина'; // optional
		$admin->save();

		$user = User::where('name', '=', 'admin')->first();

		// role attach alias
		$user->attachRole($admin); // parameter can be an Role object, array, or id
    }
}
