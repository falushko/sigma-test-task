<?php

namespace SigmaTestTask\Pricing;

use SigmaTestTask\Entity\OneTierProduct;
use SigmaTestTask\Interfaces\PricingInterface;
use SigmaTestTask\Interfaces\ProductInterface;

/**
 * Class OneTierPricing
 * @package SigmaTestTask\Pricing
 */
class OneTierPricing implements PricingInterface
{
    /**
     * @var ProductInterface[]
     */
    private $products = [];

    /**
     * @param ProductInterface $product
     */
    public function addProduct(ProductInterface $product)
    {
        if (!$product instanceof OneTierProduct) {
            throw new \InvalidArgumentException('Incompatible product type! Please use OneTierProduct');
        }

        $this->products[$product->getCode()] = $product;
    }

    /**
     * @param string $code
     * @param int $amount
     * @return float|int
     */
    public function getPriceForProductsAmount(string $code, int $amount)
    {
        $product = $this->getProductByCode($code);
        if (!$product->isSellingByPackages()) {
            return $amount * $product->getPrice();
        }

        $result = 0;
        if ($amount >= $product->getPackSize()) {
            $result += intdiv($amount, $product->getPackSize()) * $product->getPackPrice();
        }

        return $result + $amount % $product->getPackSize() * $product->getPrice();
    }

    /**
     * @param string $code
     * @return ProductInterface
     */
    public function getProductByCode(string $code): ProductInterface
    {
        if (!in_array($code, array_keys($this->products))) {
            throw new \InvalidArgumentException('Invalid product code');
        }

        return $this->products[$code];
    }

    /**
     * @return ProductInterface[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}