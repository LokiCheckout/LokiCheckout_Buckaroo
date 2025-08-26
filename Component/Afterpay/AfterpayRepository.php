<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Afterpay;

use Loki\Components\Component\ComponentRepository;
use LokiCheckout\Core\Component\Base\Generic\CheckoutContext;

/**
 * @method CheckoutContext getContext()
 */
class AfterpayRepository extends ComponentRepository
{
    private const PROPERTY_TERMS = 'termsCondition';
    private const PROPERTY_CUSTOMER_IBAN = 'customer_iban';
    private const PROPERTY_CUSTOMER_DOB = 'customer_DoB';

    public function getValue(): mixed
    {
        if (str_ends_with($this->getComponentName(), '.terms')) {
            return (int)$this->getProperty(self::PROPERTY_TERMS, 0);
        }

        if (str_ends_with($this->getComponentName(), '.iban')) {
            return (string)$this->getProperty(self::PROPERTY_CUSTOMER_IBAN, '');
        }

        if (str_ends_with($this->getComponentName(), '.dob')) {
            return (string)$this->getProperty(self::PROPERTY_CUSTOMER_DOB, '');
        }

        return '';
    }

    public function saveValue(mixed $value): void
    {
        if (str_ends_with($this->getComponentName(), '.terms')) {
            $termsCondition = (int)$value > 0 ? 1 : 0;
            $this->saveProperty(self::PROPERTY_TERMS, $termsCondition);
        }

        if (str_ends_with($this->getComponentName(), '.iban')) {
            $this->saveProperty(self::PROPERTY_CUSTOMER_IBAN, (string)$value);
        }

        if (str_ends_with($this->getComponentName(), '.dob')) {
            $this->saveProperty(self::PROPERTY_CUSTOMER_DOB, (string)$value);
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
