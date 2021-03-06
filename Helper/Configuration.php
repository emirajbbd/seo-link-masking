<?php

namespace MageSuite\SeoLinkMasking\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_SEO_LINK_MASKING_CONFIGURATION = 'seo/link_masking';
    const LINK_MASKING_PARAMETER_REGISTRY_KEY = 'link_masking_parameters';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    protected $config = null;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface
    ) {
        parent::__construct($context);

        $this->scopeConfig = $scopeConfigInterface;
    }

    public function getDefaultMaskingState()
    {
        if (!$this->isLinkMaskingEnabled()) {
            return false;
        }

        return (bool)$this->getConfig()->getDefaultMaskingState();
    }

    public function isLinkMaskingEnabled()
    {
        return (bool)$this->getConfig()->getIsEnabled();
    }

    public function onlyOneFilterDemasked()
    {
        return (bool)$this->getConfig()->getOnlyOneFilterDemasked();
    }

    public function isShortFilterUrlEnabled()
    {
        return (bool)$this->getConfig()->getIsShortFilterUrlEnabled();
    }

    public function getMultiselectOptionSeparator()
    {
        return $this->getConfig()->getMultiselectOptionSeparator();
    }

    protected function getConfig()
    {
        if ($this->config === null) {
            $this->config = new \Magento\Framework\DataObject(
                $this->scopeConfig->getValue(self::XML_PATH_SEO_LINK_MASKING_CONFIGURATION, \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
            );
        }

        return $this->config;
    }
}
