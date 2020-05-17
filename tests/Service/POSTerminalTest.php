<?php

use PHPUnit\Framework\TestCase;
use SigmaTestTask\Entity\OneTierProduct;
use SigmaTestTask\Pricing\OneTierPricing;
use SigmaTestTask\Service\POSTerminal;

class POSTerminalTest extends TestCase
{
    private $posTerminal;

    public function setUp()
    {
        $this->posTerminal = new POSTerminal();
    }

    public function testScanItem()
    {
        $pricing = new OneTierPricing();
        $pricing->addProduct(new OneTierProduct('GE', 1, 4, 5));
        $pricing->addProduct(new OneTierProduct('NL', 2, 1, 7));
        $pricing->addProduct(new OneTierProduct('FK', 6, 5, 10));

        $this->posTerminal->setPricing($pricing);

        $this->posTerminal->scanItem('GE');
        $this->posTerminal->scanItem('GE');
        $this->posTerminal->scanItem('GE');
        $this->posTerminal->scanItem('NL');
        $this->posTerminal->scanItem('NL');
        $this->posTerminal->scanItem('FK');

        $reflectionProperty = new ReflectionProperty(POSTerminal::class, 'items');
        $reflectionProperty->setAccessible(true);

        $this->assertEquals([
            'GE' => 3,
            'NL' => 2,
            'FK' => 1
        ], $reflectionProperty->getValue($this->posTerminal));
    }

    public function testScanItemLogicException()
    {
        $this->expectException(LogicException::class);

        $this->posTerminal->scanItem('GE');
    }

    public function testScanItemInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->posTerminal->setPricing(new OneTierPricing());
        $this->posTerminal->scanItem('GE');
    }

    public function testGetTotal()
    {
        $pricing = new OneTierPricing();
        $pricing->addProduct(new OneTierProduct('GE', 1, 4, 5));
        $pricing->addProduct(new OneTierProduct('NL', 2, 1, 7));
        $pricing->addProduct(new OneTierProduct('FK', 6, 5, 10));

        $this->posTerminal->setPricing($pricing);

        $this->posTerminal->scanItem('GE');
        $this->posTerminal->scanItem('GE');
        $this->posTerminal->scanItem('GE');
        $this->posTerminal->scanItem('NL');
        $this->posTerminal->scanItem('NL');
        $this->posTerminal->scanItem('FK');

        $this->assertEquals(13, $this->posTerminal->getTotal());
    }

    public function testResetItems()
    {
        $pricing = new OneTierPricing();
        $pricing->addProduct(new OneTierProduct('GE', 1, 4, 5));

        $this->posTerminal->setPricing($pricing);

        $this->posTerminal->scanItem('GE');
        $this->posTerminal->scanItem('GE');

        $this->posTerminal->resetItems();

        $reflectionProperty = new ReflectionProperty(POSTerminal::class, 'items');
        $reflectionProperty->setAccessible(true);

        $this->assertEquals([], $reflectionProperty->getValue($this->posTerminal));
    }
}