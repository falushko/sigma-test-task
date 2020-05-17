<?php

namespace SigmaTestTask\Interfaces;

/**
 * Interface PricingInterface
 * @package SigmaTestTask\Interfaces
 */
interface PricingInterface
{
    /**
     * @return array
     */
    public function getProducts(): array;

    /**
     * @param ProductInterface $product
     * @return void
     */
    public function addProduct(ProductInterface $product);

    /**
     * @param string $code
     * @return ProductInterface
     */
    public function getProductByCode(string $code): ProductInterface;
}