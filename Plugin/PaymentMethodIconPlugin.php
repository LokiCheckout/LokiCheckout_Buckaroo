<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutBuckaroo\Plugin;

use Yireo\LokiCheckout\ViewModel\PaymentMethodIcon;

class PaymentMethodIconPlugin
{
    public function afterGetIcon(
        PaymentMethodIcon $paymentMethodIcon,
        string $result,
        string $paymentMethodCode
    ): string {
        if (false === preg_match('/^buckaroo_methods_(.*)$/', $paymentMethodCode, $match)) {
            return $result;
        };

        if (empty($match)) {
            return $result;
        }

        $iconFileId = 'Buckaroo_Magento2::images/methods/'.$match[1].'.svg';
        $iconUrl = $paymentMethodIcon->getAssetRepository()->getUrl($iconFileId);

        return '<img src="'.$iconUrl.'" />';
    }
}
