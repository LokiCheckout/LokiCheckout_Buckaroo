<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Paybybank;

use Buckaroo\Magento2\Model\ConfigProvider\Method\PayByBank as PayByBankConfigProvider;
use LokiCheckout\Core\Component\Base\Generic\CheckoutContext;
use LokiCheckout\Core\Component\Base\Payment\AdditionalInformation\AdditionalInformationViewModel;

/**
 * @method CheckoutContext getContext()
 */
class PaybybankViewModel extends AdditionalInformationViewModel
{
    public function __construct(
        private PayByBankConfigProvider $payByBankConfigProvider
    ) {
    }

    public function isRequired(): bool
    {
        return true;
    }

    public function getJsComponentName(): ?string
    {
        return 'LokiCheckoutBuckarooPaybybank';
    }

    public function getIssuers(): array
    {
        return $this->payByBankConfigProvider->formatIssuers();
    }
}
