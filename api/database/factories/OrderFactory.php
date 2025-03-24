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
            'sender_fullname'               => $this->faker->name,
            'recipient_fullname'               => $this->faker->name,
            'pickup_address'          => $this->faker->address,
            'delivery_address'        => $this->faker->address,
            'item_description'        => $this->faker->paragraph,
            'status'                  => $this->faker->randomElement(['Pending', 'Processing', 'Completed', 'Cancelled']),
            'sender_phone'          => $this->faker->phoneNumber,
            'recipient_phone'          => $this->faker->phoneNumber,
            'sender_email'          => $this->faker->safeEmail,
            'delivery_type'           => $this->faker->randomElement(['Standard', 'Express', 'Same Day', 'Overnight']),
            'delivery_time_slot'      => $this->faker->time('H:i:s'),
            'distance'                => $this->faker->randomFloat(2, 1, 100),
            'estimated_delivery_time' => $this->faker->dateTime,
            'actual_delivery_time'    => $this->faker->dateTime,
            'package_weight'          => $this->faker->randomFloat(2, 0.1, 50),
            'package_dimensions'      => $this->faker->word,
            'is_fragile'              => $this->faker->boolean,
            'special_instructions'    => $this->faker->sentence,
            'payment_status'          => $this->faker->randomElement(['paid', 'unpaid', 'refunded', 'failed']),
            'payment_method'          => $this->faker->randomElement(['Credit Card', 'Cash']),
            'total_cost'              => $this->faker->randomFloat(2, 10, 500),
            'discount'                => $this->faker->randomFloat(2, 0, 50),
            // Set rider_id to null by default. If you have riders seeded, you can assign a random rider id.
            'rider_id'                => 1,
            'rider_notes'             => $this->faker->sentence,
            'admin_id'                => 1,
            'user_id'                => null,
            'pickup_time'             => $this->faker->dateTime,
            'delivery_attempts'       => $this->faker->numberBetween(0, 5),
            'failed_delivery_reason'  => $this->faker->sentence,
            'order_source'            => 'Website', // default value
            'order_priority'          => 'Medium',  // default value
            'cancellation_reason'     => $this->faker->sentence,
            'scheduled_pickup_time'   => $this->faker->dateTime,
            'scheduled_delivery_time' => $this->faker->dateTime,
            'cancelled_at'            => $this->faker->dateTime,
        ];
    }
}
