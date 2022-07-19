<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\BasketDto;
use App\Dto\Catalog\OrderCreationFormDto;
use App\Dto\Catalog\OrderDto;
use App\Exceptions\BasketNotExistingException;
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
        OrderService $orderService,
        BasketService $basketService,
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

    public function recall(int $id)
    {
        $order = $this->orderService->getById($id);


    }
}
