<?php

declare(strict_types=1);

namespace Commerce365\CustomerPriceHyva\Plugin;

use Commerce365\CustomerPrice\Service\GetProductResponseData;
use Hyva\Theme\ViewModel\CurrentProduct;

class SetCurrentProduct
{
    public function __construct(private readonly CurrentProduct $currentProduct) {}

    /**
     * @param GetProductResponseData $subject
     * @param $product
     * @param $productId
     * @return array
     */
    public function beforeExecute(GetProductResponseData $subject, $product, $productId): array
    {
        if ($product->getId() === $productId) {
            $this->currentProduct->set($product);
        }

        return [$product, $productId];
    }
}
