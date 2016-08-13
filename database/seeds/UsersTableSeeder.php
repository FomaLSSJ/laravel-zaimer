<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $faker = Faker\Factory::create();
        
        DB::table('users')->truncate();
        
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tech.com',
            'password' => bcrypt('password'),
            'balance' => 5740
        ]);
        
        for ($i = 0; $i < 49; $i++) {
            User::create([
                'name' => $faker->userName(),
                'email' => $faker->email(),
                'password' => bcrypt('password'),
                'balance' => $faker->randomNumber(4)
            ]);
        }
        
        $this->command->info('Users Seeder Complete');
    }
}
