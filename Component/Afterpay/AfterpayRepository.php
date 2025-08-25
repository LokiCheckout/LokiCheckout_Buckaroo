<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Afterpay;

use Loki\Components\Component\ComponentRepository;
use LokiCheckout\Core\Component\Base\Generic\CheckoutContext;

/**
 * @method CheckoutContext getContext()
 */
class AfterpayRepository extends ComponentRepository
{
    public function getValue(): mixed
    {
        return $this->getContext()->getQuote()->getPayment()->getAdditionalInformation();
    }

    public function saveValue(mixed $value): void
    {
        if (!is_array($value)) {
            return;
        }

        if (array_key_exists('customerIban', $value)) {
            $this->saveProperty('customer_iban', (string)$value['customerIban']);
        }

        if (array_key_exists('customerDob', $value)) {
            $this->saveProperty('customer_Dob', (string)$value['customerDob']);
        }

        if (array_key_exists('termsCondition', $value)) {
            $termsCondition = (int)$value['termsCondition'] > 0 ? 1 : 0;
            $this->saveProperty('termsCondition', $termsCondition);
        }
    }

    private function saveProperty(string $propertyName, mixed $propertyValue): void
    {
        $quote = $this->getContext()->getCheckoutState()->getQuote();
        $additionalInformation = $quote->getPayment()->getAdditionalInformation();
        $additionalInformation[$propertyName] = $propertyValue;

        $quote->getPayment()->setAdditionalInformation($additionalInformation);
        $this->getContext()->getCheckoutState()->saveQuote($quote);
    }
}
