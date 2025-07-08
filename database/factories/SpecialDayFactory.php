<?php

namespace Database\Factories;

use App\Models\SpecialDay;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpecialDayFactory extends Factory
{
    protected $model = SpecialDay::class;

    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
        ];
    }
}
