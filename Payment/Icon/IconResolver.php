<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutBuckaroo\Payment\Icon;

use Magento\Framework\Module\Manager as ModuleManager;
use Yireo\LokiCheckout\Payment\Icon\IconResolverContext;
use Yireo\LokiCheckout\Payment\Icon\IconResolverInterface;
use Yireo\LokiFieldComponents\ViewModel\ImageOutput;

class IconResolver implements IconResolverInterface
{
    public function __construct(
        private ModuleManager $moduleManager,
        private ImageOutput $imageOutput,
        private \Buckaroo\Magento2\Block\Info $infoBlock,
    ) {
    }

    public function resolve(IconResolverContext $iconResolverContext): false|string
    {
        if (false === $this->moduleManager->isEnabled('Buckaroo_Magento2')) {
            return false;
        }

        $paymentMethodCode = $iconResolverContext->getPaymentMethodCode();

        if (!preg_match('/^buckaroo_magento2_(.*)$/', $paymentMethodCode, $match)) {
            return false;
        };

        $paymentLogo = $this->infoBlock->getPaymentLogo($match[1]);
        if ($paymentLogo) {
            return $this->imageOutput->getByUrl($paymentLogo);
        }

        $iconFilePath = $iconResolverContext->getIconPath(
            'Buckaroo_Magento2',
            'view/base/web/images/svg/'.$match[1].'.svg'
        );

        return $iconResolverContext->getIconOutput($iconFilePath, 'svg');

    }
}
