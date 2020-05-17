<?php

namespace SigmaTestTask\Interfaces;

/**
 * Interface TerminalInterface
 * @package SigmaTestTask\Interfaces
 */
interface TerminalInterface
{
    /**
     * @param PricingInterface $pricing
     * @return mixed
     */
    public function setPricing(PricingInterface $pricing);

    /**
     * @param string $code
     * @return mixed
     */
    public function scanItem(string $code);

    /**
     * @return float|null
     */
    public function getTotal(): ?float;

    /**
     * @return void
     */
    public function resetItems();
}