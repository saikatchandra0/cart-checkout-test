<?php
function calculatePriceOfCart(string $cart, array $pricingRules): int
{
    $items = count_chars($cart, 1); 
    $total = 0;

    foreach ($items as $charCode => $count) {
        $sku = chr($charCode);

        if (!isset($pricingRules[$sku])) {
            throw new InvalidArgumentException("Unknown item: $sku");
        }

        $rule = $pricingRules[$sku];

        // Case 1: "N for Y"
        if (isset($rule['special'])) {
            $n = $rule['special']['n'];
            $priceN = $rule['special']['price'];
            $total += intdiv($count, $n) * $priceN;
            $total += ($count % $n) * $rule['unit'];
        }
        // Case 2: "Buy X get Y free" 
        else if (isset($rule['buy_x_get_y_free'])) {
            $x = $rule['buy_x_get_y_free']['x'];
            $y = $rule['buy_x_get_y_free']['y'];
            $groupSize = $x + $y;

            $groups = intdiv($count, $groupSize);
            $remainder = $count % $groupSize;

            $total += $groups * $x * $rule['unit'];

        }
        // Case 3: simple price
        else {
            $total += $count * $rule['unit'];
        }
    }

    return $total;
}
