<?php
declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Observer;

use Composer\InstalledVersions;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SaveModuleVersionToQuote implements ObserverInterface
{
    private const COMPOSER_MODULE_NAME = 'loki-checkout/magento2-buckaroo';

    public function execute(Observer $observer)
    {
        $quote = $observer->getQuote();

        $version = 'unknown';

        if (InstalledVersions::isInstalled(self::COMPOSER_MODULE_NAME)) {
            $version = InstalledVersions::getVersion(self::COMPOSER_MODULE_NAME);
        }

        $quote->getPayment()->setAdditionalInformation(
            'buckaroo_platform_info',
            " / Loki Checkout (".$version.")"
        );
    }
}
