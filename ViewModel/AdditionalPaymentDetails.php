<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use LokiCheckout\Core\ViewModel\CheckoutState;

class AdditionalPaymentDetails implements ArgumentInterface
{
    public function __construct(
        private readonly CheckoutState $checkoutState,
    ) {
    }

    public function getAdditionalDetails(): array
    {
        $quote = $this->checkoutState->getQuote();
        $paymentMethodCode = $quote->getPayment()->getMethod();
        $details = [];

        if ($paymentMethodCode === 'buckaroo_magento2_afterpay'
            || $paymentMethodCode === 'buckaroo_magento2_afterpay2'
        ) {
            $details = array_merge($details, $this->getAfterpayProperties());
        }

        if ($paymentMethodCode === 'buckaroo_magento2_sepadirectdebit') {
            $details = array_merge($details, $this->getSepadirectdebitProperties());
        }

        if ($paymentMethodCode === 'buckaroo_magento2_creditcard') {
            $details = array_merge($details, $this->getCreditcardProperties());
        }

        if ($paymentMethodCode === 'buckaroo_magento2_paybybank') {
            $details = array_merge($details, $this->getPaybybankProperties());
        }

        return $details;
    }

    private function getAfterpayProperties(): array
    {
        return [
            'Date of Birth:' => $this->getProperty('customer_DoB'),
            'Bank Account Number:' => $this->getProperty('customer_iban'),
        ];
    }

    private function getSepadirectdebitProperties(): array
    {
        return [
            'Bank account holder' => $this->getProperty('customer_account_name'),
            'Bank account number' => $this->getProperty('customer_iban'),
        ];
    }

    private function getPaybybankProperties(): array
    {
        return [
            'Issuer' => $this->getProperty('issuer'),
        ];
    }

    private function getCreditcardProperties(): array
    {
        return [
            'Credit Card or Debit Card' => strtoupper((string)$this->getProperty('card_type')),
        ];
    }

    private function getProperty(string $propertyName): mixed
    {
        $additionalInformation = $this->checkoutState->getQuote()->getPayment()->getAdditionalInformation();

        if (isset($additionalInformation[$propertyName])) {
            return $additionalInformation[$propertyName];
        }

        return null;
    }
}
