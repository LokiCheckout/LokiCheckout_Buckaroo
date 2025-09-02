<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Afterpay;

use LokiCheckout\Core\Component\Base\Generic\CheckoutContext;
use LokiCheckout\Core\Component\Base\Payment\AdditionalInformation\AdditionalInformationRepository;
use LokiCheckout\Core\Component\Base\Payment\AdditionalInformation\AdditionalInformationViewModel;

/**
 * @method CheckoutContext getContext()
 * @method AdditionalInformationRepository getRepository()
 */
class AfterpayViewModel extends AdditionalInformationViewModel
{
    public function isRequired(): bool
    {
        return $this->isAllowRendering();
    }

    public function isAllowRendering(): bool
    {
        $propertyName = $this->getRepository()->getPropertyName();
        $billingAddress = $this->getContext()->getCheckoutState()->getQuote()->getBillingAddress();

        if ($propertyName === 'customer_identificationNumber') {
            return $billingAddress->getCountryId() === 'FI';
        }

        if ($propertyName === 'customer_coc') {
            // @todo: Check for customer_type to be b2c
            return false === empty($billingAddress->getCompany());
        }

        if ($propertyName === 'customer_telephone') {
            return in_array($billingAddress->getCountryId(), ['NL', 'BE']) && empty($billingAddress->getTelephone());
        }

        if ($propertyName === 'customer_DoB') {
            return in_array($billingAddress->getCountryId(), ['NL', 'BE']) && empty($billingAddress->getCompany());
        }

        return parent::isAllowRendering();
    }

    public function getInputLabel(): string
    {
        if ($this->getRepository()->getPropertyName() === 'termsCondition') {
            return (string)__(
                'The general Terms and Conditions for the Riverty payment method apply. The privacy policy of Riverty can be found here.'
            );
        }

        return '';
    }

    public function getComment(): string
    {
        if ($this->getRepository()->getPropertyName() !== 'termsCondition') {
            return '';
        }

        $text = $this->getContext()->getScopeConfig()->getValue(
            'loki_checkout/buckaroo/afterpay_terms'
        );

        if (empty($text)) {
            return '';
        }

        return (string)__(
            $text,
            $this->getPaymentMethodLabel(),
            $this->getTermsAndConditionsUrl(),
            $this->getPrivacyPolicyUrl(),
            $this->getCookieStatementUrl(),
        );
    }

    private function getPaymentMethodLabel(): string
    {
        return (string)$this->getContext()->getQuote()->getPayment()
            ->getMethodInstance()->getTitle();
    }

    private function getTermsAndConditionsUrl(): string
    {
        return (string)$this->getContext()->getScopeConfig()->getValue(
            'loki_checkout/buckaroo/afterpay_terms_conditions_url'
        );
    }

    private function getPrivacyPolicyUrl(): string
    {
        return (string)$this->getContext()->getScopeConfig()->getValue(
            'loki_checkout/buckaroo/afterpay_privacy_statement_url'
        );
    }

    private function getCookieStatementUrl(): string
    {
        return (string)$this->getContext()->getScopeConfig()->getValue(
            'loki_checkout/buckaroo/afterpay_cookie_statement_url'
        );
    }
}
