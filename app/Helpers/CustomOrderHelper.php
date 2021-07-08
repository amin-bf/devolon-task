<?php

namespace App\Helpers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SpecialPrice;

/**
 * Helper class responsible for special price calculation
 */
class CustomOrderHelper
{
    /**
     * Calculates order items' special price depending on rules applied to product
     *
     * @param Product $product
     * @param integer $quantity
     *
     * @return float
     */
    public static function getItemSpecialPrice(Product $product, int $quantity): float
    {
        $price = 0;

        // Add to 'price' from top most rule to bottom
        foreach ($product->specialPrices as $specialPrice) {
            /** @var SpecialPrice $specialPrice */
            if ($specialPrice->quantity > $quantity) continue;

            while (!($specialPrice->quantity > $quantity)) {
                $quantity -= $specialPrice->quantity;
                $price += $specialPrice->price;
            }
        }

        // Return the calculated price or the remaining products' price (not eligible to any rule) added to it
        if (!$quantity) return $price;
        else return $price + ($quantity * $product->price);
    }

    /**
     * Merges old duplicate item for current product with current item and delete the old item
     *
     * @param OrderItem $orderItem The new item before save
     * @param Product $product The related product
     *
     * @return void
     */
    public static function mergeDuplicate(OrderItem &$orderItem, Product $product)
    {
        /** @var Order $order */
        $order = $orderItem->order()->first();

        /** @var OrderItem $oldItemForSameProduct */
        $oldItemForSameProduct = $order->orderItems()->where("product_id", $product->id)->first();

        if ($oldItemForSameProduct) {
            $orderItem->amount = (int)$oldItemForSameProduct->amount + (int)$orderItem->amount;
            $orderItem->quantity = (int)$oldItemForSameProduct->quantity + (int)$orderItem->quantity;

            $oldItemForSameProduct->delete();
        }
    }
}
