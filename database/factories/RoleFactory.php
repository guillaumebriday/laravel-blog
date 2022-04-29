<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word()
        ];
    }

    /**
     * Indicate that the user is admin.
     */
    public function admin(): Factory
    {
        return $this->state(function () {
            return [
                'name' => 'admin'
            ];
        });
    }

    /**
     * Indicate that the user is editor.
     */
    public function editor(): Factory
    {
        return $this->state(function () {
            return [
                'name' => 'editor'
            ];
        });
    }
}
