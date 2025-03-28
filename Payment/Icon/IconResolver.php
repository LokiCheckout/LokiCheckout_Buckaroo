<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutPayNl\Payment\Icon;

use Magento\Framework\Module\Manager as ModuleManager;
use Paynl\Payment\Model\Config;
use Yireo\LokiCheckout\Payment\Icon\IconResolverContext;
use Yireo\LokiCheckout\Payment\Icon\IconResolverInterface;

class IconResolver implements IconResolverInterface
{
    public function __construct(
        private Config $config,
        private ModuleManager $moduleManager,
    ) {
    }

    public function resolve(IconResolverContext $iconResolverContext): false|string
    {
        $paymentMethodCode = $iconResolverContext->getPaymentMethodCode();
        if (false === $this->moduleManager->isEnabled('Paynl_Payment')) {
            return false;
        }

        if (!preg_match('/^paynl_(.*)$/', $paymentMethodCode)) {
            return false;
        }

        return '<img src="'.$this->config->getIconUrl($paymentMethodCode).'" />';
    }
}
