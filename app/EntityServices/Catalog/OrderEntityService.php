<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\BasketDto;
use App\Dto\Catalog\OrderCreationFormDto;
use App\Dto\Catalog\OrderDto;
use App\Dto\Catalog\OrderUpdateDto;
use App\Dto\PaginationDto;
use App\Exceptions\Basket\BasketEmptyException;
use App\Exceptions\Basket\BasketNotExistingException;
use App\Exceptions\Order\NoRightsRecallOrderException;
use App\Exceptions\Order\OrderCannotRecalledException;
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
     * @throws BasketEmptyException
     */
    public function create(OrderCreationFormDto $dto): OrderDto
    {
        $basket = BasketDto::fromModel($this->basketService->getBasketById($dto->basketId));

        if ($basket->totalCount < 1){
            throw new BasketEmptyException();
        }

        $newOrder = $this->orderService->create($dto);

        $orderItems = $this->orderService->fromBasketToOrderProductList($basket, $newOrder->getId());

        foreach ($orderItems as $item) {
            $this->productService->reduceQuantityStockByNumber($item->getProductId(), $item->getCount());
            $item->save();
        }

        $this->basketService->deactivateBasket($dto->basketId);

        return OrderDto::fromModel($newOrder);
    }

    /**
     * @throws OrderCannotRecalledException
     * @throws NoRightsRecallOrderException
     */
    public function recall(string $id): void
    {
        $order = $this->orderService->getById($id);

        if (!$this->orderService->canRecallOrder($order)) {
            throw new OrderCannotRecalledException();
        }

        $this->orderService->recall($order);
    }

    public function getUpdateData(string $id): OrderDto
    {
        $order = $this->orderService->getById($id);

        return OrderDto::fromModel($order);
    }

    public function update(string $id, OrderUpdateDto $dto): OrderDto
    {
        $order = $this->orderService->getById($id);

        $changedOrder = $this->orderService->update($order, $dto);

        return OrderDto::fromModel($changedOrder);
    }
}
