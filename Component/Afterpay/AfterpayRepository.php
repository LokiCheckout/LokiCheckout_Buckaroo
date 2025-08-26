<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Afterpay;

use LokiCheckout\Core\Component\Base\Generic\CheckoutContext;
use LokiCheckout\Core\Component\Base\Payment\AdditionalInformation\AdditionalInformationRepository;

/**
 * @method CheckoutContext getContext()
 */
class AfterpayRepository extends AdditionalInformationRepository
{
    public function getValue(): mixed
    {
        $defaultValue = '';
        if ($this->getPropertyName() === 'termsCondition') {
            $defaultValue = 0;
        }

        return $this->getPropertyValue($defaultValue);
    }

    public function saveValue(mixed $value): void
    {
        if ($this->getPropertyName() === 'termsCondition') {
            $value = (int)$value > 0 ? 1 : 0;
        } else {
            $value = (string)$value;
        }

        $this->saveProperty($value);
    }
}
