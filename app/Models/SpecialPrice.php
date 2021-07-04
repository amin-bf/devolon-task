<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialPrice extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "product_id",
        "quantity",
        "price"
    ];

    /**
     * Get the product that owns the SpecialPrice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
