<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Models\Catalog\Order;

class OrderDto extends BaseDto
{
    public int $id;
    public int $userId;
    public string $userName;
    public string $userEmail;
    public int $deliveryId;
    public ?string $deliveryAddress;
    /** @var \App\Dto\Catalog\OrderItemDto[] */
    public array $items;
    public int $orderStatusId;
    public int $paymentStatusId;
    public ?int $createdAt;
    public ?int $updatedAt;

    public static function fromModel(Order $order): self
    {
        $itemDtoList = OrderItemDto::fromList($order->items()->getResults()->all());

        return new self([
            'id' => $order->getId(),
            'userId' => $order->getUserId(),
            'userName' => $order->getUserName(),
            'userEmail' => $order->getUserEmail(),
            'deliveryId' => $order->getDeliveryId(),
            'deliveryAddress' => $order->getDeliveryAddress(),
            'items' => $itemDtoList,
            'orderStatusId' => $order->getOrderStatusId(),
            'paymentStatusId' => $order->getPaymentStatusId(),
            'updatedAt' => $order->getUpdatedAtTimestamp(),
            'createdAt' => $order->getCreatedAtTimestamp(),
        ]);
    }
}
