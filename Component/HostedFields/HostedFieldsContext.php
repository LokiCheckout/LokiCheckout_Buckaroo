<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutBuckaroo\Component\HostedFields;

use Yireo\LokiCheckout\Util\Component\StepProvider;
use Yireo\LokiCheckout\ViewModel\CheckoutState;
use Yireo\LokiCheckoutBuckaroo\Service\TokenService;
use Yireo\LokiComponents\Component\ComponentContextInterface;

class HostedFieldsContext implements  ComponentContextInterface
{
    public function __construct(
        private CheckoutState $checkoutState,
        private StepProvider $stepProvider,
        private TokenService $tokenService
    ) {
    }

    public function getCheckoutState(): CheckoutState
    {
        return $this->checkoutState;
    }

    public function getStepProvider(): StepProvider
    {
        return $this->stepProvider;
    }

    public function getTokenService(): TokenService
    {
        return $this->tokenService;
    }
}
