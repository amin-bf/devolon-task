<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        "order_id",
        "product_id",
        "quantity",
        "amount"
    ];

    public $timestamps = false;

    protected static function booted()
    {
        static::saved(function (OrderItem $orderItem) {
            $orderItem->order->touch();
        });

        static::saving(function ($orderItem) {
            static::mergeDuplicate($orderItem);

            $product = $orderItem->product()->first();
            $orderItem->amount = $product->price * $orderItem->quantity;
        });
    }

    /**
     * Get the Order that owns the OrderItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get the product that owns the OrderItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * Merges old duplicate item for current product with current item and delete the old item
     *
     * @param OrderItem $orderItem The new item before save
     *
     * @return void
     */
    private static function mergeDuplicate(OrderItem $orderItem)
    {
        $order = $orderItem->order()->first();
        $product = $orderItem->product()->first();

        $oldItemForSameProduct = $order->orderItems()->where("product_id", $product->id)->first();

        if ($oldItemForSameProduct) {
            $orderItem->amount = (int)$oldItemForSameProduct->amount + (int)$orderItem->amount;
            $orderItem->quantity = (int)$oldItemForSameProduct->quantity + (int)$orderItem->quantity;

            $oldItemForSameProduct->delete();
        }
    }
}
