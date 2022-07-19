<?php

namespace App\Services\Catalog;

use App\Dto\Catalog\OrderCreationFormDto;
use App\Dto\Catalog\OrderDto;
use App\Helpers\Mappers\Order\OrderProduct;
use App\Helpers\Statuses\Order\OrderPaymentStatuses;
use App\Helpers\Statuses\Order\OrderStatuses;
use App\Models\Catalog\Order;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    use OrderProduct;

    public function getById(int $id)
    {
        return Order::query()->findOrFail($id)->first();
    }

    /**
     * @param User $user
     * @return OrderDto[]
     */
    public function getListByUser(User $user): array
    {
        $orders = $user->orders()->getResults()->all();

        return OrderDto::fromList($orders);
    }

    public function create(OrderCreationFormDto $dto): Order
    {
        return Order::create(
            Auth::user()->id,
            Auth::user()->name,
            Auth::user()->email,
            $dto->deliveryId,
            $dto->deliveryAddress,
            OrderStatuses::PROCESSING,
            OrderPaymentStatuses::NOT_PAID
        )->saveAndReturn();
    }

    public function canRecallOrder(Order $model): bool
    {

    }
}
