<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutBuckaroo\Payment\Redirect;

use Buckaroo\Magento2\Model\Method\AbstractMethod;
use Yireo\LokiCheckout\Payment\Redirect\RedirectResolverInterface;
use Yireo\LokiCheckout\Step\FinalStep\RedirectContext;

class RedirectResolver implements RedirectResolverInterface
{
    public function resolve(RedirectContext $redirectContext): false|string
    {
        $paymentMethod = $redirectContext->getPaymentMethod();
        if (false === $paymentMethod instanceof AbstractMethod) {
            return false;
        }

        return $paymentMethod->getOrderPlaceRedirectUrl();
    }
}
