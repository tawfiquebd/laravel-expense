<?php

namespace Database\Factories;

use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ExpenseFactory extends Factory
{

    protected $model = Expense::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 5),
            'name' => $this->faker->words(5, true),
            'cost' => $this->faker->randomFloat(2, 20, 100),
        ];
    }
}
