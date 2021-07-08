<?php

namespace App\Models;

use App\Helpers\CustomOrderHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * OrderItem model
 */
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

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        // Notify 'order' to update it's 'total'
        static::saved(function (OrderItem $orderItem) {
            $orderItem->order->touch();
        });

        static::saving(function ($orderItem) {
            $product = $orderItem->product()->first();

            // Merge items with the same 'product'
            CustomOrderHelper::mergeDuplicate($orderItem, $product);

            // Calculate item's special price depending on product's rules
            $orderItem->amount = CustomOrderHelper::getItemSpecialPrice($product, $orderItem->quantity);
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
}
