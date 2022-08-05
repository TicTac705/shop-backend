<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\OrderCreationFormDto;
use App\Dto\Catalog\OrderDto;
use App\Dto\Catalog\OrderUpdateDto;
use App\Dto\PaginationDto;
use App\Exceptions\AppException;
use App\Exceptions\Basket\BasketEmptyException;
use App\Exceptions\Basket\BasketNotExistingException;
use App\Exceptions\Catalog\InvalidQuantityProductException;
use App\Exceptions\Catalog\UnavailabilityException;
use App\Exceptions\Order\NoRightsRecallOrderException;
use App\Exceptions\Order\OrderCannotRecalledException;
use App\PivotModels\Catalog\BasketProduct;
use App\Services\Catalog\BasketService;
use App\Services\Catalog\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderEntityService
{
    private OrderService $orderService;
    private BasketService $basketService;

    public function __construct(
        OrderService   $orderService,
        BasketService  $basketService
    )
    {
        $this->orderService = $orderService;
        $this->basketService = $basketService;
    }

    /**
     * @return OrderDto[]
     * @throws AppException
     */
    public function getList(): array
    {
        return $this->orderService->getListByUser(Auth::user());
    }

    public function getListWithPagination(int $numberItemsPerPage): PaginationDto
    {
        $orders = $this->orderService->getListWithPagination($numberItemsPerPage);

        return PaginationDto::fromResultService($orders, OrderDto::fromList($orders->items()));
    }

    /**
     * @throws BasketNotExistingException
     * @throws BasketEmptyException
     * @throws AppException
     * @throws UnavailabilityException
     * @throws InvalidQuantityProductException
     */
    public function create(OrderCreationFormDto $dto): OrderDto
    {
        $basket = $this->basketService->getBasketById($dto->basketId);

        if (count($basket->getPositions()) < 1) {
            throw new BasketEmptyException();
        }

        /** @var BasketProduct[]|null $basketItems */
        $basketItems = $basket->getPositions();

        $orderItems = $this->orderService->getItemsFromBasket($basketItems);

        $newOrder = $this->orderService->create($dto, $orderItems);

        $this->basketService->deactivateBasket($dto->basketId);

        return OrderDto::fromModel($newOrder);
    }

    /**
     * @throws OrderCannotRecalledException
     * @throws NoRightsRecallOrderException
     * @throws AppException
     */
    public function recall(string $id): void
    {
        $order = $this->orderService->getById($id);

        if (!$this->orderService->canRecallOrder($order)) {
            throw new OrderCannotRecalledException();
        }

        $this->orderService->recall($order);
    }

    /**
     * @throws AppException
     */
    public function getUpdateData(string $id): OrderDto
    {
        $order = $this->orderService->getById($id);

        return OrderDto::fromModel($order);
    }

    /**
     * @throws AppException
     */
    public function update(string $id, OrderUpdateDto $dto): OrderDto
    {
        $order = $this->orderService->getById($id);

        $changedOrder = $this->orderService->update($order, $dto);

        return OrderDto::fromModel($changedOrder);
    }
}
