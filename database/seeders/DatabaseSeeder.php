<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Expense;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        User::factory(10)->create();
//        Expense::factory(10)->create();

        User::factory(5)->create()->each(function($user) {
            Expense::factory(rand(1, 10))->create([
                'user_id' => $user->id
            ]);
        });

    }
}
