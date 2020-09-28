<?php

use App\PhoneNumber;
use App\User;
use Illuminate\Database\Seeder;

class PhoneNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {

            PhoneNumber::create([
                'user_id' => $user->id,
                'number' => $user->phone
            ]);

        }
    }
}
