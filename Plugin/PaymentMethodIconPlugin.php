<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutBuckaroo\Plugin;

use Magento\Framework\Component\ComponentRegistrar;
use Yireo\LokiCheckout\ViewModel\PaymentMethodIcon;

class PaymentMethodIconPlugin
{
    public function afterGetIcon(
        PaymentMethodIcon $paymentMethodIcon,
        string $result,
        string $paymentMethodCode
    ): string {

        if (!preg_match('/^buckaroo_magento2_(.*)$/', $paymentMethodCode, $match)) {
            return $result;
        };

        $iconFilePath = $paymentMethodIcon->getIconPath(
            'Buckaroo_Magento2',
            'view/base/web/images/svg/'.$match[1].'.svg'
        );

        return $paymentMethodIcon->getIconOutput($iconFilePath, 'svg');
    }
}
