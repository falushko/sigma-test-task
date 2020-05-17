<?php

use PHPUnit\Framework\TestCase;
use SigmaTestTask\Entity\OneTierProduct;

class OneTierProductTest extends TestCase
{
    public function testConstructorThirdInvalidArg()
    {
        $this->expectException(InvalidArgumentException::class);

        new OneTierProduct('QQ', 10, 10);
    }

    public function testConstructorFourthInvalidArg()
    {
        $this->expectException(InvalidArgumentException::class);

        new OneTierProduct('QQ', 10, null, 10);
    }

    /**
     * @dataProvider isSellingByPackagesDataProvider
     * @param $expected
     * @param $oneTierProduct
     */
    public function testIsSellingByPackages($expected, OneTierProduct $oneTierProduct)
    {
        $this->assertEquals($expected, $oneTierProduct->isSellingByPackages());
    }

    public function isSellingByPackagesDataProvider()
    {
        return [
            [true, new OneTierProduct('QQ', 10, 10, 10)],
            [false, new OneTierProduct('QQ', 10)],
        ];
    }
}