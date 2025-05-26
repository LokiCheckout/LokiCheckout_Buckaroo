<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutBuckaroo\Payment\Redirect;

use Buckaroo\Magento2\Model\Method\AbstractMethod;
use Yireo\LokiCheckout\Payment\Redirect\RedirectResolverInterface;
use Yireo\LokiCheckout\Step\FinalStep\RedirectContext;
use Magento\Framework\Registry;

class RedirectResolver implements RedirectResolverInterface
{
    public function __construct(
        private Registry $registry
    ) {
    }

    public function resolve(RedirectContext $redirectContext): false|string
    {
        $paymentMethod = $redirectContext->getPaymentMethod();
        if (false === $paymentMethod instanceof AbstractMethod) {
            return false;
        }

        $redirectUrl = $this->getUrlFromResponse();
        if (!empty($redirectUrl)) {
            return $redirectUrl;
        }

        $redirectUrl = $paymentMethod->getOrderPlaceRedirectUrl();
        if (is_string($redirectUrl)) {
            return $redirectUrl;
        }

        return false;
    }


    private function getUrlFromResponse(): string
    {
        $response = $this->registry->registry('buckaroo_response');
        if (!empty($response)) {
            return (string)$response[0]->RequiredAction->RedirectURL;
        }

        return '';
    }
}
