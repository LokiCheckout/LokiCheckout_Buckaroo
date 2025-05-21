<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutBuckaroo\Component\HostedFields;

use Yireo\LokiComponents\Component\ComponentRepository;

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

        $additionalInformation = [];

        $quote = $this->getContext()->getCheckoutState()->getQuote();
        $quote->getPayment()->setAdditionalInformation($additionalInformation);
        $this->getContext()->getCheckoutState()->saveQuote($quote);
    }
}
