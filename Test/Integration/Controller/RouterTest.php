<?php

namespace MageSuite\SeoLinkMasking\Test\Integration\Controller;

/**
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class RouterTest extends \Magento\TestFramework\TestCase\AbstractController
{
    const DEFAULT_OPTION_SEPARATOR = '--';

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture loadFilterableProducts
     * @magentoConfigFixture current_store seo/link_masking/is_short_filter_url_enabled 1
     */
    public function testItSetFiltersByValues()
    {
        $this->dispatch('/test-category/option+1');

        $this->assertContains('Multiselect Attribute', $this->getResponse()->getBody());

        $parameters = $this->getRequest()->getParams();

        $this->assertArrayHasKey('multiselect_attribute', $parameters);
        $this->assertEquals('Option 1', $parameters['multiselect_attribute']);
    }

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture loadFilterableProducts
     * @magentoConfigFixture current_store seo/link_masking/is_short_filter_url_enabled 1
     */
    public function testItSetFilterWithMultipleOptions()
    {
        $this->dispatch('/test-category/option+1--option+2');

        $this->assertContains('Multiselect Attribute', $this->getResponse()->getBody());

        $parameters = $this->getRequest()->getParams();

        $this->assertArrayHasKey('multiselect_attribute', $parameters);
        $this->assertCount(2, $parameters['multiselect_attribute']);
        $this->assertEquals(['Option 1', 'Option 2'], $parameters['multiselect_attribute']);
    }

    public static function loadFilterableProducts()
    {
        require __DIR__.'/../_files/filterable_products.php';
    }

    public static function loadFilterableProductsRollback()
    {
        require __DIR__.'/../_files/filterable_products_rollback.php';
    }
}
