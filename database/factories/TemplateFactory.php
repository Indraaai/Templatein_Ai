<?php

namespace Database\Factories;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Template>
 */
class TemplateFactory extends Factory
{
    protected $model = Template::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'type' => fake()->randomElement(['skripsi', 'proposal', 'laporan']),
            'description' => fake()->sentence(),
            'template_rules' => json_encode([]), // Default empty array JSON
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the template is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the template has rules.
     */
    public function withRules(array $rules = null): static
    {
        if ($rules === null) {
            $rules = [
                [
                    'type' => 'section',
                    'title' => 'BAB I PENDAHULUAN',
                    'components' => [
                        'heading' => ['bold' => true],
                        'content' => ['enabled' => true]
                    ]
                ]
            ];
        }

        return $this->state(fn(array $attributes) => [
            'template_rules' => json_encode($rules),
        ]);
    }
}
