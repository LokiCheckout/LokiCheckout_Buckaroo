<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Afterpay;

use LokiCheckout\Core\Component\Base\Generic\CheckoutContext;
use LokiCheckout\Core\Component\Base\Generic\CheckoutViewModel;

/**
 * @method CheckoutContext getContext()
 */
class AfterpayViewModel extends CheckoutViewModel
{
    public function getJsComponentName(): ?string
    {
        return 'LokiCheckoutBuckarooAfterpay';
    }

    public function getCustomerDob(): string
    {
        return (string)$this->getProperty('customer_Dob', '');
    }

    public function getCustomerIban(): string
    {
        return (string)$this->getProperty('customer_iban', '');
    }

    public function getTermsCondition(): int
    {
        return (int)$this->getProperty('termsCondition', 0);
    }

    public function getTermsConditionsText(): string
    {
        return (string)$this->getContext()->getScopeConfig()->getValue('loki_checkout/buckaroo/afterpay_terms');
    }

    public function getPaymentMethodLabel(): string
    {
        return (string)$this->getContext()->getQuote()->getPayment()->getMethodInstance()->getTitle();
    }

    public function getTermsAndConditionsUrl(): string
    {
        return (string)$this->getContext()->getScopeConfig()->getValue('loki_checkout/buckaroo/afterpay_terms_conditions_url');
    }

    public function getPrivacyPolicyUrl(): string
    {
        return (string)$this->getContext()->getScopeConfig()->getValue('loki_checkout/buckaroo/afterpay_privacy_statement_url');
    }

    public function getCookieStatementUrl(): string
    {
        return (string)$this->getContext()->getScopeConfig()->getValue('loki_checkout/buckaroo/afterpay_cookie_statement_url');
    }

    private function getProperty(string $propertyName, mixed $defaultValue = null): mixed
    {
        $additionalInformation = $this->getValue();
        if (array_key_exists($propertyName, $additionalInformation)) {
            return $additionalInformation[$propertyName];
        }

        return $defaultValue;
    }
}
