<?php

use PHPUnit\Framework\TestCase;
use SigmaTestTask\Entity\OneTierProduct;
use SigmaTestTask\Interfaces\ProductInterface;
use SigmaTestTask\Pricing\OneTierPricing;

class OneTierPricingTest extends TestCase
{
    private $oneTierPricing;

    public function setUp()
    {
        $this->oneTierPricing = new OneTierPricing();
    }

    public function testAddProduct()
    {
        $product = new OneTierProduct('GE', 1);
        $this->oneTierPricing->addProduct($product);

        $this->assertEquals($product, $this->oneTierPricing->getProducts()['GE']);
    }

    public function testAddProductException()
    {
        $this->expectException(InvalidArgumentException::class);

        $incompatibleClass = new class() implements ProductInterface {
            public function getPrice(): float { return 1; }
            public function getCode(): string { return ''; }
        };

        $this->oneTierPricing->addProduct($incompatibleClass);
    }

    public function testGetProductByCode()
    {
        $product = new OneTierProduct('GE', 1);
        $this->oneTierPricing->addProduct($product);

        $this->assertEquals($product, $this->oneTierPricing->getProductByCode('GE'));
    }

    public function testGetProductByCodeException()
    {
        $this->expectException(InvalidArgumentException::class);

        $product = new OneTierProduct('GE', 1);
        $this->oneTierPricing->addProduct($product);
        $this->oneTierPricing->getProductByCode('MN');
    }

    /**
     * @dataProvider getPriceForProductsAmountDataProvider
     * @param OneTierProduct $oneTierProduct
     * @param int $amount
     * @param float $expectedPrice
     */
    public function testGetPriceForProductsAmount(OneTierProduct $oneTierProduct, int $amount, float $expectedPrice)
    {
        $this->oneTierPricing->addProduct($oneTierProduct);

        $this->assertEquals($expectedPrice, $this->oneTierPricing->getPriceForProductsAmount($oneTierProduct->getCode(), $amount));
    }

    public function getPriceForProductsAmountDataProvider()
    {
        return [
            [new OneTierProduct('GE', 2), 5, 10],
            [new OneTierProduct('LN', 3, 5, 2), 1, 3],
            [new OneTierProduct('DS', 5, 13, 3), 5, 23]
        ];
    }
}