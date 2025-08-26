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
        return true;
    }

    public function getMax(): string
    {
        if (str_ends_with($this->getComponentName(), '.dob')) {
            return date('Y-m-d');
        }

        return parent::getMax();
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
        if ($this->getRepository()->getPropertyName() === 'termsCondition') {
            $text = $this->getContext()->getScopeConfig()->getValue(
                'loki_checkout/buckaroo/afterpay_terms'
            );

            return (string)
            __(
                $text,
                $this->getPaymentMethodLabel(),
                $this->getTermsAndConditionsUrl(),
                $this->getPrivacyPolicyUrl(),
                $this->getCookieStatementUrl(),
            );
        }

        return '';
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
