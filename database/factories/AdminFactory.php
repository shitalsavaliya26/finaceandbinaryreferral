<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Admin',
            'username' => 'test',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$v9gNzFAXwUHCp87uRLiSDe3WGCir9fF/U50MQRdg4QLh92flVMYC6', // test@1234
            'is_super' => '0',
            'remember_token' => Str::random(10),
            //
        ];
    }
}
