<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Afterpay;

use Loki\Field\Component\Base\Field\FieldViewModel;
use LokiCheckout\Core\Component\Base\Generic\CheckoutContext;

/**
 * @method CheckoutContext getContext()
 */
class AfterpayViewModel extends FieldViewModel
{
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

    public function getFieldLabel(): string
    {
        if (str_ends_with($this->getComponentName(), '.terms')) {
            return (string)__('Terms and Conditions');
        }

        if (str_ends_with($this->getComponentName(), '.iban')) {
            return (string)__('Bank Account Number:');
        }

        if (str_ends_with($this->getComponentName(), '.dob')) {
            return (string)__('Date of Birth:');
        }

        return '';
    }
}
