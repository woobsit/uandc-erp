<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fullname'               => $this->faker->name,
            'pickup_address'          => $this->faker->address,
            'delivery_address'        => $this->faker->address,
            'item_description'        => $this->faker->paragraph,
            'status'                  => $this->faker->randomElement(['Pending', 'Processing', 'Completed', 'Cancelled']),
            'customer_phone'          => $this->faker->phoneNumber,
            'customer_email'          => $this->faker->optional()->safeEmail,
            'delivery_type'           => 'Standard', // default value
            'delivery_time_slot'      => $this->faker->optional()->time('H:i:s'),
            'distance'                => $this->faker->optional()->randomFloat(2, 1, 100),
            'estimated_delivery_time' => $this->faker->optional()->dateTime,
            'actual_delivery_time'    => $this->faker->optional()->dateTime,
            'package_weight'          => $this->faker->optional()->randomFloat(2, 0.1, 50),
            'package_dimensions'      => $this->faker->optional()->word,
            'is_fragile'              => $this->faker->boolean,
            'special_instructions'    => $this->faker->optional()->sentence,
            'payment_status'          => 'Unpaid', // default value
            'payment_method'          => $this->faker->optional()->randomElement(['Credit Card', 'Cash', 'PayPal']),
            'total_cost'              => $this->faker->randomFloat(2, 10, 500),
            'discount'                => $this->faker->randomFloat(2, 0, 50),
            // Set rider_id to null by default. If you have riders seeded, you can assign a random rider id.
            'rider_id'                => null,
            'rider_notes'             => $this->faker->optional()->sentence,
            'admin_id'                => 1,
            'user_id'                => null,
            'pickup_time'             => $this->faker->optional()->dateTime,
            'delivery_attempts'       => $this->faker->numberBetween(0, 5),
            'failed_delivery_reason'  => $this->faker->optional()->sentence,
            'order_source'            => 'Website', // default value
            'order_priority'          => 'Medium',  // default value
            'cancellation_reason'     => $this->faker->optional()->sentence,
            'scheduled_pickup_time'   => $this->faker->optional()->dateTime,
            'scheduled_delivery_time' => $this->faker->optional()->dateTime,
            'cancelled_at'            => $this->faker->optional()->dateTime,
        ];
    }
}
