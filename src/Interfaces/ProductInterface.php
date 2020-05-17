<?php

namespace SigmaTestTask\Interfaces;

/**
 * Interface ProductInterface
 * @package SigmaTestTask\Interfaces
 */
interface ProductInterface
{
    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return float
     */
    public function getPrice(): float;
}