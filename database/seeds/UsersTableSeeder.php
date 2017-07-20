<?php

use Illuminate\Database\Seeder;

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
            'username' => 'truonghedspi',
            'email' => 'truong.hn.1994@gmail.com',
            'password' => bcrypt('dunghoi'),
            'is_admin' => 1
        ]);
    }
}
