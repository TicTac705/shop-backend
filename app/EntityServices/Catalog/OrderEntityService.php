<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\BasketDto;
use App\Dto\Catalog\OrderCreationFormDto;
use App\Dto\Catalog\OrderDto;
use App\Dto\Catalog\OrderUpdateDto;
use App\Dto\PaginationDto;
use App\Exceptions\Basket\BasketNotExistingException;
use App\Exceptions\Order\NoRightsRecallOrder;
use App\Exceptions\Order\OrderCannotRecalled;
use App\Services\Catalog\BasketService;
use App\Services\Catalog\OrderService;
use App\Services\Catalog\ProductService;
use Illuminate\Support\Facades\Auth;

class OrderEntityService
{
    private OrderService $orderService;
    private BasketService $basketService;
    private ProductService $productService;

    public function __construct(
        OrderService   $orderService,
        BasketService  $basketService,
        ProductService $productService
    )
    {
        $this->orderService = $orderService;
        $this->basketService = $basketService;
        $this->productService = $productService;
    }

    /**
     * @return OrderDto[]
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
     */
    public function create(OrderCreationFormDto $dto): OrderDto
    {
        $basket = BasketDto::fromModel($this->basketService->getBasketById($dto->basketId));

        $newOrder = $this->orderService->create($dto);

        $orderItems = $this->orderService->fromBasketToOrderProductList($basket, $newOrder->getId());

        foreach ($orderItems as $item) {
            $this->productService->reduceQuantityStockByNumber($item->getProductId(), $item->getCount());
        }

        $this->basketService->deactivateBasket($dto->basketId);

        $newOrder->items()->saveMany($orderItems);

        return OrderDto::fromModel($newOrder);
    }

    /**
     * @throws OrderCannotRecalled
     * @throws NoRightsRecallOrder
     */
    public function recall(int $id): void
    {
        $order = $this->orderService->getById($id);

        if (!$this->orderService->canRecallOrder($order)) {
            throw new OrderCannotRecalled();
        }

        $this->orderService->recall($order);
    }

    public function getUpdateData(int $id): OrderDto
    {
        $order = $this->orderService->getById($id);

        return OrderDto::fromModel($order);
    }

    public function update(int $id, OrderUpdateDto $dto): OrderDto
    {
        $order = $this->orderService->getById($id);

        $changedOrder = $this->orderService->update($order, $dto);

        return OrderDto::fromModel($changedOrder);
    }
}
