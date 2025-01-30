<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutBuckaroo\Plugin;

use Magento\Framework\Component\ComponentRegistrar;
use Yireo\LokiCheckout\ViewModel\PaymentMethodIcon;

class PaymentMethodIconPlugin
{
    public function __construct(
        private ComponentRegistrar $componentRegistrar
    ) {
    }

    public function afterGetIcon(
        PaymentMethodIcon $paymentMethodIcon,
        string $result,
        string $paymentMethodCode
    ): string {

        if (!preg_match('/^buckaroo_magento2_(.*)$/', $paymentMethodCode, $match)) {
            return $result;
        };

        if (empty($match)) {
            return $result;
        }

        $modulePath = $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, 'Buckaroo_Magento2');
        $iconFilePath = $modulePath . '/view/base/web/images/svg/'.$match[1].'.svg';
        if (false === file_exists($iconFilePath)) {
            return $result;
        }

        return file_get_contents($iconFilePath);
    }
}
