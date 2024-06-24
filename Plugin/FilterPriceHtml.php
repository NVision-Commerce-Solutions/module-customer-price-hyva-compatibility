<?php

declare(strict_types=1);

namespace Commerce365\CustomerPriceHyva\Plugin;

use Commerce365\CustomerPrice\Service\PriceInfoProvider\PriceHtmlProvider;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Design\Theme\ThemeProviderInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Theme\Model\Theme\StoreThemesResolver;

class FilterPriceHtml
{
    public function __construct(
        private readonly StoreManagerInterface $storeManager,
        private readonly StoreThemesResolver $storeThemesResolver,
        private readonly ThemeProviderInterface $themeProvider
    ) {}

    /**
     * @param PriceHtmlProvider $subject
     * @param callable $proceed
     * @param ProductInterface $product
     * @param null $mainProductId
     * @param string $mainProductType
     * @return string
     * @throws NoSuchEntityException
     */
    public function aroundGet(
        PriceHtmlProvider $subject,
        callable $proceed,
        ProductInterface $product,
        $mainProductId = null,
        $mainProductType = ''
    ): string {
        $store = $this->storeManager->getStore();
        $themes = $this->storeThemesResolver->getThemes($store);
        $themeId = array_shift($themes);
        $theme = $this->themeProvider->getThemeById($themeId);
        if (!strpos($theme->getCode(), 'hyva')) {
            return $proceed($product, $mainProductId, $mainProductType);
        }

        if (!$mainProductId || $product->getId() !== $mainProductId) {
            return $proceed($product, $mainProductId, $mainProductType);
        }

        return '';
    }
}
