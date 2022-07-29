<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Models\Catalog\Order;

class OrderDto extends BaseDto
{
    public string $id;
    public string $userId;
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
        $itemDtoList = OrderItemDto::fromList($order->items()->all());

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

    /**
     * @param Order[] $items
     * @return self[]
     */
    public function fromList(array $items): array
    {
        return array_map(fn(Order $item): self => self::fromModel($item), $items);
    }
}
