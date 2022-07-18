<?php

namespace App\Services\Catalog;

use App\Dto\Catalog\BasketDto;
use App\Dto\Catalog\OrderCreationFormDto;
use App\Dto\Catalog\OrderDto;
use App\Exceptions\BasketNotExistingException;
use App\Helpers\Mappers\Order\OrderProduct;
use App\Helpers\Statuses\Order\OrderPaymentStatuses;
use App\Helpers\Statuses\Order\OrderStatuses;
use App\Models\Catalog\Order;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    use OrderProduct;

    private ProductService $productService;
    private BasketService $basketService;

    public function __construct(ProductService $productService, BasketService $basketService)
    {
        $this->productService = $productService;
        $this->basketService = $basketService;
    }

    /**
     * @throws BasketNotExistingException
     */
    public function create(OrderCreationFormDto $dto): OrderDto
    {
        $basket = BasketDto::fromModel($this->basketService->getBasketById($dto->basketId));

        $newOrder = Order::create(
            Auth::user()->id,
            Auth::user()->name,
            Auth::user()->email,
            $dto->deliveryId,
            $dto->deliveryAddress,
            OrderStatuses::PROCESSING,
            OrderPaymentStatuses::NOT_PAID
        )->saveAndReturn();

        $orderItems = $this->fromBasketToOrderProductList($basket, $newOrder->getId());

        foreach ($orderItems as $item) {
            $this->productService->reduceQuantityStockByNumber($item->getProductId(), $item->getCount());
        }

        $this->basketService->deactivateBasket($dto->basketId);

        $newOrder->items()->saveMany($orderItems);

        return OrderDto::fromModel($newOrder);
    }
}
