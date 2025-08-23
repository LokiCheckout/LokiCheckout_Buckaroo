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

        $additionalInformation = []; // @todo: Pass through the right information

        $quote = $this->getContext()->getCheckoutState()->getQuote();
        $quote->getPayment()->setAdditionalInformation($additionalInformation);
        $this->getContext()->getCheckoutState()->saveQuote($quote);
    }
}
