<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\HostedFields;

use Magento\Framework\App\Config\ScopeConfigInterface;
use LokiCheckout\Core\Util\Component\StepProvider;
use LokiCheckout\Core\ViewModel\CheckoutState;
use LokiCheckout\Buckaroo\Service\TokenService;
use Loki\Components\Component\ComponentContextInterface;

class HostedFieldsContext implements  ComponentContextInterface
{
    public function __construct(
        private CheckoutState $checkoutState,
        private StepProvider $stepProvider,
        private TokenService $tokenService,
        private ScopeConfigInterface $scopeConfig
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

    public function getScopeConfig(): ScopeConfigInterface
    {
        return $this->scopeConfig;
    }
}
