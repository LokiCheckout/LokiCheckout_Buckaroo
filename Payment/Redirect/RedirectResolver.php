<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Payment\Redirect;

use Buckaroo\Magento2\Model\Method\AbstractMethod;
use LokiCheckout\Core\Payment\Redirect\RedirectResolverInterface;
use LokiCheckout\Core\Step\FinalStep\RedirectContext;
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
        if (!empty($response) && !empty($response[0]) && !empty($response[0]->RequiredAction)) {
            return (string)$response[0]->RequiredAction->RedirectURL;
        }

        return '';
    }
}
