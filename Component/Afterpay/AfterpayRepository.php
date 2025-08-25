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
        if (str_ends_with($this->getComponentName(), '.terms')) {
            return (int)$this->getProperty('termsCondition', 0);
        }

        if (str_ends_with($this->getComponentName(), '.iban')) {
            return (string)$this->getProperty('customer_iban', '');
        }

        if (str_ends_with($this->getComponentName(), '.dob')) {
            return (string)$this->getProperty('customer_Dob', '');
        }

        return '';
    }

    public function saveValue(mixed $value): void
    {
        if (str_ends_with($this->getComponentName(), '.terms')) {
            $termsCondition = (int)$value > 0 ? 1 : 0;
            $this->saveProperty('termsCondition', $termsCondition);
        }

        if (str_ends_with($this->getComponentName(), '.iban')) {
            $this->saveProperty('customer_iban', (string)$value);
        }

        if (str_ends_with($this->getComponentName(), '.dob')) {
            $this->saveProperty('customer_Dob', (string)$value);
        }
    }

    private function getProperty(string $propertyName, mixed $defaultValue = null): mixed
    {
        $additionalInformation = $this->getAdditionalPaymentInformation();
        if (array_key_exists($propertyName, $additionalInformation)) {
            return $additionalInformation[$propertyName];
        }

        return $defaultValue;
    }

    private function saveProperty(string $propertyName, mixed $propertyValue): void
    {
        $quote = $this->getContext()->getCheckoutState()->getQuote();
        $additionalInformation = $this->getAdditionalPaymentInformation();
        $additionalInformation[$propertyName] = $propertyValue;

        $quote->getPayment()->setAdditionalInformation($additionalInformation);
        $this->getContext()->getCheckoutState()->saveQuote($quote);
    }

    private function getAdditionalPaymentInformation(): array
    {
        return $this->getContext()->getCheckoutState()->getQuote()->getPayment()->getAdditionalInformation();
    }
}
