<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    #[\Override]
    protected $model = Role::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word()
        ];
    }

    /**
     * Indicate that the user is admin.
     */
    public function admin(): Factory
    {
        return $this->state(fn (): array => [
            'name' => 'admin'
        ]);
    }

    /**
     * Indicate that the user is editor.
     */
    public function editor(): Factory
    {
        return $this->state(fn (): array => [
            'name' => 'editor'
        ]);
    }
}
