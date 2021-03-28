<?php

use Carbon\Carbon;
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
        $dt = Carbon::now();
        $dateNow = $dt->toDateTimeString();
        DB::table('users')->insert(array(
            array(
                'name' => 'Abdus Samad',
                'mobile' => '01823151351',
                'role_id' => '1',
                'email' => 'samad1230@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$R7L3AYru2Nf5ZT7fDNchJOA5gTGybQk72cEaOvnBwUGG8h4mrS4Yy',
                'image' => NULL,
                'status' => '1',
                'remember_token' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL
            ),
        ));
    }
}
