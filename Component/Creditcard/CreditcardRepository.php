<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Creditcard;

use Loki\Components\Component\ComponentRepository;

/**
 * @method CreditcardContext getContext()
 */
class CreditcardRepository extends ComponentRepository
{
    public function getValue(): mixed
    {
        $quote = $this->getContext()->getCheckoutState()->getQuote();
        $additionalInformation = $quote->getPayment()->getAdditionalInformation();
        return $additionalInformation['card_type'] ?? null;
    }

    public function saveValue(mixed $value): void
    {
        if (!is_string($value)) {
            return;
        }

        $quote = $this->getContext()->getCheckoutState()->getQuote();
        $additionalInformation = $quote->getPayment()->getAdditionalInformation();
        $additionalInformation['card_type'] = $value;

        $quote->getPayment()->setAdditionalInformation($additionalInformation);
        $this->getContext()->getCheckoutState()->saveQuote($quote);
    }
}
