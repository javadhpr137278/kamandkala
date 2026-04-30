<?php

namespace App\Services;

use App\Models\Discount;
use App\Models\Gift_card;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DiscountService
{
    public function applyDiscountToOrder(Order $order, $discountCode)
    {
        $discount = Discount::where('code', $discountCode)->first();

        if (!$discount || !$discount->isValid()) {
            throw new \Exception('کد تخفیف نامعتبر است');
        }

        $discountAmount = $discount->calculateDiscount($order->subtotal);

        if ($discountAmount == 0) {
            throw new \Exception('کد تخفیف قابل اعمال نیست');
        }

        DB::transaction(function () use ($order, $discount, $discountAmount) {
            $discount->increment('used_count');

            $order->update([
                'discount_id' => $discount->id,
                'discount_amount' => $discountAmount,
                'total' => $order->subtotal - $discountAmount
            ]);
        });

        return $discountAmount;
    }

    public function applyGiftCardToOrder(Order $order, $giftCardCode)
    {
        $giftCard = Gift_card::where('code', $giftCardCode)->first();

        if (!$giftCard || !$giftCard->isValid()) {
            throw new \Exception('کارت هدیه نامعتبر است');
        }

        $remainingAmount = $order->total;
        $useAmount = min($giftCard->current_balance, $remainingAmount);

        DB::transaction(function () use ($order, $giftCard, $useAmount) {
            $giftCard->use($useAmount);

            $order->update([
                'gift_card_id' => $giftCard->id,
                'gift_card_amount' => $useAmount,
                'total' => $order->total - $useAmount
            ]);

            $giftCard->transactions()->create([
                'order_id' => $order->id,
                'amount' => $useAmount,
                'type' => 'used'
            ]);
        });

        return $useAmount;
    }
}
