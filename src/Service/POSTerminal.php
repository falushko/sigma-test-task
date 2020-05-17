<?php

namespace SigmaTestTask\Service;

use SigmaTestTask\Interfaces\PricingInterface;
use SigmaTestTask\Interfaces\TerminalInterface;

/**
 * Class POSTerminal
 * @package SigmaTestTask\Service
 */
class POSTerminal implements TerminalInterface
{
    /**
     * @var PricingInterface
     */
    private $pricing;

    /**
     * ['CODE' => amount]
     * @var array
     */
    private $items = [];

    /**
     * @param PricingInterface $pricing
     */
    public function setPricing(PricingInterface $pricing)
    {
        $this->pricing = $pricing;
    }

    /**
     * @param string $code
     */
    public function scanItem(string $code)
    {
        if ($this->pricing === null) {
            throw new \LogicException('Pricing is not defined');
        }

        if (!in_array($code, array_keys($this->pricing->getProducts()))) {
            throw new \InvalidArgumentException('Invalid product code');
        }

        if (!array_key_exists($code, $this->items)) {
            $this->items[$code] = 0;
        }

        $this->items[$code] += 1;
    }

    /**
     * @return float|null
     */
    public function getTotal(): ?float
    {
        $total = 0;
        foreach ($this->items as $code => $amount) {
            $total += $this->pricing->getPriceForProductsAmount($code, $amount);
        }

        return $total;
    }

    /**
     * @return void
     */
    public function resetItems()
    {
        $this->items = [];
    }
}