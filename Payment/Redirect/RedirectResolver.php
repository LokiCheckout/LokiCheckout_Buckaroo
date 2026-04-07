<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Payment\Redirect;

use Buckaroo\Magento2\Model\Method\BuckarooAdapter;
use LokiCheckout\Core\Payment\Redirect\RedirectResolverInterface;
use LokiCheckout\Core\Step\FinalStep\RedirectContext;
use Buckaroo\Magento2\Api\Data\BuckarooResponseDataInterface;
use Magento\Framework\Registry;

class RedirectResolver implements RedirectResolverInterface
{

    public function __construct(
        private readonly Registry $registry,
        private readonly BuckarooResponseDataInterface $buckarooResponseData,
    ) {
    }

    public function resolve(RedirectContext $redirectContext): false|string
    {
        $paymentMethod = $redirectContext->getPaymentMethod();

        if (false === $paymentMethod instanceof BuckarooAdapter) {
            return false;
        }

        if ($this->hasRedirect()) {
            return $this->getResponse()->RequiredAction->RedirectURL;
        }

        if ($this->isSuccessfulPayment()) {
            return 'checkout/onepage/success';
        }

        if (method_exists($paymentMethod, 'getOrderPlaceRedirectUrl')) {
            $redirectUrl = $paymentMethod->getOrderPlaceRedirectUrl();
            if (is_string($redirectUrl)) {
                return $redirectUrl;
            }
        }

        return false;
    }

    private function getResponse()
    {
        if ($this->registry->registry('buckaroo_response')) {
            return $this->registry->registry('buckaroo_response')[0];
        }

        if ($this->buckarooResponseData->getResponse()) {
            return json_decode(json_encode($this->buckarooResponseData->getResponse()->toArray()));
        }

        return null;
    }


    private function hasRedirect(): bool
    {
        $response = $this->getResponse();

        return !empty($response->RequiredAction->RedirectURL);
    }

    private function isSuccessfulPayment(): bool
    {
        $response = $this->getResponse();
        if (!$response) {
            return false;
        }

        return !empty($response->Status->Code->Code) && $response->Status->Code->Code == 190;
    }
}
