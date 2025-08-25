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

        return $details;
    }

    private function getAfterpayProperties(): array
    {
        return [
            'Date of Birth:' => $this->getProperty('customer_Dob'),
            'Bank Account Number:' => $this->getProperty('customer_iban'),
        ];
    }

    private function getProperty(string $propertyName): mixed
    {
        $additionalInformation = $this->checkoutState->getQuote()->getPayment()
            ->getAdditionalInformation();
        if (isset($additionalInformation[$propertyName])) {
            return $additionalInformation[$propertyName];
        }

        return null;
    }
}
