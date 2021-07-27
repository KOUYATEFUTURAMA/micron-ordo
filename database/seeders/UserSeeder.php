<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_name' => "Concepteur de l'application",
            'email' => 'Concepteur@app.com',
            'contact' => '00000000',
            'role' => 'Concepteur',
            'password' => bcrypt('P@ssword@123456'),
            'created_at' => now()
        ]);
    }
}
