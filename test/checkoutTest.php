<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../checkout.php';

class CheckoutTest extends TestCase
{
    private array $rules = [
        'A' => ['unit' => 50, 'special' => ['n' => 3, 'price' => 130]],
        'B' => ['unit' => 30, 'special' => ['n' => 2, 'price' => 45]],
        'C' => ['unit' => 20, 'buy_x_get_y_free' => ['x' => 2, 'y' => 1]],
        'D' => ['unit' => 15],
    ];

    public function testSingleItems()
    {
        $this->assertEquals(50, calculatePriceOfCart("A", $this->rules));
        $this->assertEquals(30, calculatePriceOfCart("B", $this->rules));
        $this->assertEquals(20, calculatePriceOfCart("C", $this->rules));
        $this->assertEquals(15, calculatePriceOfCart("D", $this->rules));
    }

    public function testSpecialOffers()
    {
        $this->assertEquals(130, calculatePriceOfCart("AAA", $this->rules));
        $this->assertEquals(45, calculatePriceOfCart("BB", $this->rules));
        $this->assertEquals(40, calculatePriceOfCart("CC", $this->rules));
        $this->assertEquals(40, calculatePriceOfCart("CCC", $this->rules));
    }
    
    public function mixCartItem()
    {
          $this->assertEquals(95, calculatePriceOfCart("BAB", $this->rules));
          $this->assertEquals(290, calculatePriceOfCart("AABBCABD", $this->rules));

    }
}
