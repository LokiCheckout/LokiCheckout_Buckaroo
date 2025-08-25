<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Creditcard;

use Magento\Framework\App\Config\ScopeConfigInterface;
use LokiCheckout\Core\Util\Component\StepProvider;
use LokiCheckout\Core\ViewModel\CheckoutState;
use Loki\Components\Component\ComponentContextInterface;

class CreditcardContext implements ComponentContextInterface
{
    public function __construct(
        private CheckoutState $checkoutState,
        private StepProvider $stepProvider,
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

    public function getScopeConfig(): ScopeConfigInterface
    {
        return $this->scopeConfig;
    }
}
