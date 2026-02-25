<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Afterpay;

use LokiCheckout\Core\Component\Base\Generic\CheckoutContext;
use LokiCheckout\Core\Component\Base\Payment\AdditionalInformation\AdditionalInformationRepository;
use LokiCheckout\Core\Component\Base\Payment\AdditionalInformation\AdditionalInformationViewModel;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * @method CheckoutContext getContext()
 * @method AdditionalInformationRepository getRepository()
 */
class AfterpayViewModel extends AdditionalInformationViewModel
{
    const CUSTOMER_TYPE_B2B = 'b2b';
    const CUSTOMER_TYPE_B2C = 'b2c';
    const CUSTOMER_TYPE_BOTH = 'both';

    public function isAllowRendering(): bool
    {
        $propertyName = $this->getRepository()->getPropertyName();
        $billingAddress = $this->getBillingAddress();

        if ($propertyName === 'customer_identificationNumber') {
            return $billingAddress->getCountryId() === 'FI';
        }

        if ($propertyName === 'customer_coc') {
            return $this->isB2B();
        }

        if ($propertyName === 'customer_telephone') {
            return $this->isCountry(['NL', 'BE']) && empty($billingAddress->getTelephone());
        }

        if ($propertyName === 'customer_DoB') {
            return $this->isCountry(['NL', 'BE']) && $this->isB2C();
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
            'loki_checkout/buckaroo/afterpay_terms',
            ScopeInterface::SCOPE_STORE
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
            'loki_checkout/buckaroo/afterpay_terms_conditions_url',
            ScopeInterface::SCOPE_STORE
        );
    }

    private function getPrivacyPolicyUrl(): string
    {
        return (string)$this->getContext()->getScopeConfig()->getValue(
            'loki_checkout/buckaroo/afterpay_privacy_statement_url',
            ScopeInterface::SCOPE_STORE
        );
    }

    private function getCookieStatementUrl(): string
    {
        return (string)$this->getContext()->getScopeConfig()->getValue(
            'loki_checkout/buckaroo/afterpay_cookie_statement_url',
            ScopeInterface::SCOPE_STORE
        );
    }

    private function getCustomerType(): string
    {
        return (string)$this->getContext()->getScopeConfig()->getValue(
            'payment/buckaroo_magento2_afterpay20/customer_type',
            ScopeInterface::SCOPE_STORE
        );
    }

    private function isB2C(): bool
    {
        if ($this->getCustomerType() === self::CUSTOMER_TYPE_B2C) {
            return true;
        }

        if ($this->getCustomerType() === self::CUSTOMER_TYPE_BOTH) {
            return $this->getBillingAddress()->getCompany() === '';
        }

        return false;
    }

    private function isB2B(): bool
    {
        if ($this->getCustomerType() === self::CUSTOMER_TYPE_B2B) {
            return true;
        }

        if ($this->getCustomerType() === self::CUSTOMER_TYPE_BOTH) {
            return strlen($this->getBillingAddress()->getCompany()) > 0;
        }

        return false;
    }

    private function isCountry(array $countryIds): bool
    {
        return in_array($this->getBillingAddress()->getCountryId(), $countryIds);
    }

    private function getBillingAddress(): AddressInterface
    {
        return $this->getContext()->getCheckoutState()->getQuote()->getBillingAddress();
    }
}
