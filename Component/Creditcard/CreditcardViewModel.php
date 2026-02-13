<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Creditcard;

use Buckaroo\Magento2\Model\ConfigProvider\Method\Creditcard as CreditcardConfigProvider;
use LokiCheckout\Core\Component\Base\Generic\CheckoutContext;
use LokiCheckout\Core\Component\Checkout\Billing\PaymentMethod\PaymentMethodViewModel;

/**
 * @method CheckoutContext getContext()
 */
class CreditcardViewModel extends PaymentMethodViewModel
{
    public function __construct(
        private readonly CreditcardConfigProvider $creditcardConfigProvider
    ) {
    }

    public function getJsComponentName(): ?string
    {
        return 'LokiCheckoutBuckarooCreditcard';
    }

    public function getCards(): array
    {
        return $this->creditcardConfigProvider->formatIssuers();
    }
}
