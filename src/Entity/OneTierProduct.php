<?php

namespace SigmaTestTask\Entity;

use SigmaTestTask\Interfaces\ProductInterface;

/**
 * Class OneTierProduct
 * @package SigmaTestTask\Entity
 */
class OneTierProduct implements ProductInterface
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var float
     */
    private $price;

    /**
     * @var float|null
     */
    private $packPrice;

    /**
     * @var int|null
     */
    private $packSize;

    /**
     * @param string $code
     * @param float $price
     * @param float $packPrice
     * @param int $packSize
     */
    public function __construct(string $code, float $price, float $packPrice = null, int $packSize = null)
    {
        if (!$this->isPackValid($packPrice, $packSize)) {
            throw new \InvalidArgumentException('You should provide either both $packPrice and $packSize or nothing');
        }

        $this->code = $code;
        $this->price = $price;
        $this->packPrice = $packPrice;
        $this->packSize = $packSize;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return float|null
     */
    public function getPackPrice(): ?float
    {
        return $this->packPrice;
    }

    /**
     * @return int|null
     */
    public function getPackSize(): ?int
    {
        return $this->packSize;
    }

    /**
     * @return bool
     */
    public function isSellingByPackages()
    {
        return $this->packPrice !== null && $this->packSize !== null;
    }

    /**
     * @param float|null $packPrice
     * @param int|null $packSize
     * @return bool
     */
    private function isPackValid(float $packPrice = null, int $packSize = null)
    {
        return ($packPrice !== null && $packSize !== null) || ($packPrice === null && $packSize === null);
    }
}