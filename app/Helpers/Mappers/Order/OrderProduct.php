<?php

namespace App\Helpers\Mappers\Order;

use App\Dto\Catalog\BasketDto;
use App\Dto\Catalog\BasketItemDto;
use App\PivotModels\Catalog\OrderProduct as OrderProductModel;

trait OrderProduct
{
    /**
     * @param BasketDto $basket
     * @param string $orderId
     * @return OrderProductModel[]
     */
    public function fromBasketToOrderProductList(BasketDto $basket, string $orderId): array
    {
        return array_map(
            function (BasketItemDto $item) use ($orderId): OrderProductModel {
                return OrderProductModel::create(
                    $orderId,
                    $item->product->id,
                    $item->product->price,
                    $item->count
                );
            },
            $basket->items
        );
    }
}
