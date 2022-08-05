<?php

namespace App\Services\Catalog;

use App\Dto\Catalog\OrderCreationFormDto;
use App\Dto\Catalog\OrderDto;
use App\Dto\Catalog\OrderUpdateDto;
use App\Exceptions\AppException;
use App\Exceptions\Catalog\InvalidQuantityProductException;
use App\Exceptions\Catalog\UnavailabilityException;
use App\Exceptions\Order\NoRightsRecallOrderException;
use App\Helpers\Statuses\Order\OrderPaymentStatuses;
use App\Helpers\Statuses\Order\OrderStatuses;
use App\Models\Catalog\Order;
use App\Models\Catalog\Product;
use App\Models\User\User;
use App\PivotModels\Catalog\BasketProduct;
use App\PivotModels\Catalog\OrderProduct;
use App\Services\User\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class OrderService
{

    /**
     * @throws AppException
     */
    public function getById(string $id)
    {
        return Order::getById($id);
    }

    /**
     * @param User $user
     * @return OrderDto[]
     * @throws AppException
     */
    public function getListByUser(User $user): array
    {
        $orders = $user->orders()->all();

        return OrderDto::fromList($orders);
    }

    public function getListWithPagination(int $number): LengthAwarePaginator
    {
        return Order::getListWithPagination($number, true);
    }

    /**
     * @param OrderCreationFormDto $dto
     * @param OrderProduct[] $orderItems
     * @return Order
     */
    public function create(OrderCreationFormDto $dto, array $orderItems): Order
    {
        return Order::create(
            Auth::user()->id,
            Auth::user()->name,
            Auth::user()->email,
            $dto->deliveryId,
            $dto->deliveryAddress,
            OrderStatuses::PROCESSING,
            OrderPaymentStatuses::NOT_PAID,
            $orderItems
        )->saveAndReturn();
    }

    /**
     * @throws NoRightsRecallOrderException
     */
    public function canRecallOrder(Order $model): bool
    {
        if (!$this->isOrderCreator($model) || !UserService::isAdmin(Auth::user())) {
            throw new NoRightsRecallOrderException();
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

    /**
     * @param BasketProduct[] $basketItems
     * @return OrderProduct[]
     * @throws AppException
     * @throws InvalidQuantityProductException
     * @throws UnavailabilityException
     */
    public function getItemsFromBasket(array $basketItems): array
    {
        return array_map(
        /**
         * @throws UnavailabilityException
         * @throws AppException
         * @throws InvalidQuantityProductException
         */
            function (BasketProduct $item) {
                /** @var Product $product */
                $product = Product::getById($item->productId);

                if (!$product->getIsActive()) {
                    throw new UnavailabilityException();
                }

                if ($product->getStore() < 1 || $product->getStore() < $item->count) {
                    throw new InvalidQuantityProductException();
                }

                $product->setStore($product->getStore() - $item->count);
                $product->checkChangesAndSave();

                return OrderProduct::create(
                    $product->getId(),
                    $product->getPrice(),
                    $item->count
                );
            },
            $basketItems
        );
    }
}
