<?php
namespace Database\Factories;

use App\Enums\ProjectStatusEnum;
use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::pluck('id');
        $clients = Client::pluck('id');
        return [
            'uuid' => Str::uuid(),
            'title'       => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(ProjectStatusEnum::cases())->value,
            'deadline_at'=> now()->addDays(rand(1,30))->format('Y-m-d'),
            'user_id' => $users->random(),
            'client_id' => $clients->random(),
        ];
    }
}
