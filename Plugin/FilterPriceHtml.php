<?php

declare(strict_types=1);

namespace Commerce365\CustomerPriceHyva\Plugin;

use Commerce365\CustomerPrice\Service\PriceInfoProvider\PriceHtmlProvider;
use Magento\Catalog\Api\Data\ProductInterface;

class FilterPriceHtml
{
    /**
     * @param PriceHtmlProvider $subject
     * @param callable $proceed
     * @param ProductInterface $product
     * @param null $mainProductId
     * @param string $mainProductType
     * @return string
     */
    public function aroundGet(
        PriceHtmlProvider $subject,
        callable $proceed,
        ProductInterface $product,
        $mainProductId = null,
        $mainProductType = ''
    ): string {
        if (!$mainProductId || $product->getId() !== $mainProductId) {
            return $proceed($product, $mainProductId, $mainProductType);
        }

        return '';
    }
}
