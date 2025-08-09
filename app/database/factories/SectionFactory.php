<?php
    namespace Database\Factories;

    use App\Models\Section;
    use Illuminate\Database\Eloquent\Factories\Factory;
    use Illuminate\Support\Str;
    class SectionFactory extends Factory
    {
        public function definition(): array
        {
            return [
                'name' => fake()->unique()->words(2, true),
                'description' => fake()->sentence(),
            ];
        }
    }
