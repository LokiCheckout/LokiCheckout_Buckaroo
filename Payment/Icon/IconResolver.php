<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Payment\Icon;

use Buckaroo\Magento2\Block\Info;
use Magento\Framework\Module\Manager as ModuleManager;
use LokiCheckout\Core\Payment\Icon\IconResolverContext;
use LokiCheckout\Core\Payment\Icon\IconResolverInterface;
use Loki\Field\ViewModel\ImageOutput;

class IconResolver implements IconResolverInterface
{
    public function __construct(
        private ModuleManager $moduleManager,
        private ImageOutput $imageOutput,
        private Info $infoBlock,
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
