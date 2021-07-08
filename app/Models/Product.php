<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Product model
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "price"
    ];

    public $timestamps = false;

    /**
     * Get all of the SpecialPrices for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specialPrices(): HasMany
    {
        return $this->hasMany(SpecialPrice::class, 'product_id', 'id')->orderBy("price", "desc");
    }

    /**
     * Get all of the OrderItems for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }
}
