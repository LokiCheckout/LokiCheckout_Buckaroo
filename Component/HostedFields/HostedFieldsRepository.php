<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\HostedFields;

use Loki\Components\Component\ComponentRepository;

/**
 * @method HostedFieldsContext getContext()
 */
class HostedFieldsRepository extends ComponentRepository
{
    public function getValue(): mixed
    {
        return null;
    }

    public function saveValue(mixed $value): void
    {
        if (!is_array($value)) {
            return;
        }

        $quote = $this->getContext()->getCheckoutState()->getQuote();

        $quote->getPayment()->setAdditionalInformation('customer_encrypteddata', $value['token']);
        $quote->getPayment()->setAdditionalInformation(
            'customer_creditcardcompany',
            $value['service'] ?? 'visa'
        );


        $this->getContext()->getCheckoutState()->saveQuote($quote);
    }
}
