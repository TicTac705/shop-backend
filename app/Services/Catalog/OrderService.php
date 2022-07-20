<?php

namespace App\Services\Catalog;

use App\Dto\Catalog\OrderCreationFormDto;
use App\Dto\Catalog\OrderDto;
use App\Dto\Catalog\OrderUpdateDto;
use App\Exceptions\Order\NoRightsRecallOrder;
use App\Helpers\Mappers\Order\OrderProduct;
use App\Helpers\Statuses\Order\OrderPaymentStatuses;
use App\Helpers\Statuses\Order\OrderStatuses;
use App\Models\Catalog\Order;
use App\Models\User\User;
use App\Services\User\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function getListWithPagination(int $number): LengthAwarePaginator
    {
        return Order::getListWithPagination($number);
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

    /**
     * @throws NoRightsRecallOrder
     */
    public function canRecallOrder(Order $model): bool
    {
        if (!$this->isOrderCreator($model) || !UserService::isAdmin(Auth::user())) {
            throw new NoRightsRecallOrder();
        }

        if ($model->isCanceled()) {
            return false;
        }

        if ((!$model->isProcessing() && !$model->isAssembly()) || !$model->isNotPaid()) {
            return false;
        }

        return true;
    }

    public function isOrderCreator(Order $model): bool
    {
        return Auth::user()->id === $model->getUserId();
    }

    public function recall(Order $model): void
    {
        $model->setOrderStatusId(OrderStatuses::CANCELED);

        $model->checkChangesAndSave();
    }

    public function update(Order $model, OrderUpdateDto $dto): Order
    {
        if ($userName = $dto->userName) {
            $model->setUserName($userName);
        }

        if ($userEmail = $dto->userEmail) {
            $model->setUserEmail($userEmail);
        }

        if ($deliveryId = $dto->deliveryId) {
            $model->setDeliveryId($deliveryId);
        }

        if ($deliveryAddress = $dto->deliveryAddress) {
            $model->setDeliveryAddress($deliveryAddress);
        }

        if ($orderStatusId = $dto->orderStatusId) {
            $model->setOrderStatusId($orderStatusId);
        }

        if ($paymentStatusId = $dto->paymentStatusId) {
            $model->setPaymentStatusId($paymentStatusId);
        }

        return $model->checkChangesSaveAndReturn();
    }
}
