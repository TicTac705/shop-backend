<?php

namespace App\Models\Catalog;

use App\Models\ModelBase;
use App\PivotModels\Catalog\OrderProduct;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string $user_name
 * @property string $user_email
 * @property int $delivery_id
 * @property null|string $delivery_address
 * @property int $order_status_id
 * @property int $payment_status_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Order extends ModelBase
{
    protected $table = 'catalog_orders';

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'delivery_id',
        'delivery_address',
        'order_status_id',
        'payment_status_id',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function create(
        int     $userId,
        string  $userName,
        string  $userEmail,
        int     $deliveryId,
        ?string $deliveryAddress,
        int     $orderStatusId,
        int     $paymentStatusId
    ): self
    {
        $order = new self();

        $order->setUserId($userId);
        $order->setUserName($userName);
        $order->setUserEmail($userEmail);
        $order->setDeliveryId($deliveryId);
        $order->setDeliveryAddress($deliveryAddress);
        $order->setOrderStatusId($orderStatusId);
        $order->setPaymentStatusId($paymentStatusId);

        return $order;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $userId): void
    {
        $this->user_id = $userId;
    }

    public function getUserName(): string
    {
        return $this->user_name;
    }

    public function setUserName(string $userName): void
    {
        $this->user_name = $userName;
    }

    public function getUserEmail(): string
    {
        return $this->user_email;
    }

    public function setUserEmail(string $userEmail): void
    {
        $this->user_email = $userEmail;
    }

    public function getDeliveryId(): int
    {
        return $this->delivery_id;
    }

    public function setDeliveryId(int $deliveryId): void
    {
        $this->delivery_id = $deliveryId;
    }

    public function getDeliveryAddress(): ?string
    {
        return $this->delivery_address;
    }

    public function setDeliveryAddress(?string $deliveryAddress = null): void
    {
        $this->delivery_address = $deliveryAddress;
    }

    public function getOrderStatusId(): int
    {
        return $this->order_status_id;
    }

    public function setOrderStatusId(int $orderStatusId): void
    {
        $this->order_status_id = $orderStatusId;
    }

    public function getPaymentStatusId(): int
    {
        return $this->payment_status_id;
    }

    public function setPaymentStatusId(int $paymentStatusId): void
    {
        $this->payment_status_id = $paymentStatusId;
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }
}
