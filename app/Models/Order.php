<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Order model
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "total"
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        // Update total if there are any items
        static::saving(function ($order) {
            $orderItems = $order->orderItems()->get();

            if ($orderItems->count()) {
                $order->total = $orderItems->sum("amount");
            }
        });
    }

    /**
     * Get all of the orderItems for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
