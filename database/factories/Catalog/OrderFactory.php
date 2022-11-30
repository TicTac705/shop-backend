<?php

namespace Database\Factories\Catalog;

use App\Helpers\Statuses\Order\DeliveryStatuses;
use App\Helpers\Statuses\Order\OrderPaymentStatuses;
use App\Helpers\Statuses\Order\OrderStatuses;
use App\Models\Catalog\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => '',
            'user_name' => '',
            'user_email' => '',
            'delivery_id' => DeliveryStatuses::COURIER_DELIVERY,
            'delivery_address' => $this->faker->address(),
            'order_status_id' => OrderStatuses::PROCESSING,
            'payment_status_id' => OrderPaymentStatuses::NOT_PAID,
            'positions' => [],
        ];
    }
}
