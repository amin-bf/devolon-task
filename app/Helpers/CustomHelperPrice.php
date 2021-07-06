<?php

namespace App\Helpers;

use App\Models\Product;
use App\Models\SpecialPrice;
use Exception;

class CustomHelperPrice
{
    public static function getSpecialPrice(Product $product, int $quantity): float
    {
        dump("In helper", $product->toJson(), $quantity);

        $price = 0;

        foreach ($product->specialPrices as $specialPrice) {
            /** @var SpecialPrice $specialPrice */
            dump("special price", $specialPrice->toJson());
            if ($specialPrice->quantity > $quantity) continue;

            while (!($specialPrice->quantity > $quantity)) {
                $quantity -= $specialPrice->quantity;
                $price += $specialPrice->price;
            }
        }

        if (!$quantity) return $price;
        else return $price + ($quantity * $product->price);
    }
}
