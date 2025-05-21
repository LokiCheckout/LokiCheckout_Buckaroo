<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutBuckaroo\Component\HostedFields;

use Yireo\LokiCheckout\ViewModel\CheckoutState;
use Yireo\LokiComponents\Component\ComponentContextInterface;

class HostedFieldsContext implements  ComponentContextInterface
{
    public function __construct(
        private CheckoutState $checkoutState,
    ) {
    }

    public function getCheckoutState(): CheckoutState
    {
        return $this->checkoutState;
    }
}
