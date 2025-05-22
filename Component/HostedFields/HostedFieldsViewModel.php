<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutBuckaroo\Component\HostedFields;

use Yireo\LokiCheckout\Component\Base\Generic\CheckoutViewModel;

/**
 * @method HostedFieldsContext getContext()
 */
class HostedFieldsViewModel extends CheckoutViewModel
{
    public function getJsComponentName(): ?string
    {
        return 'LokiCheckoutBuckarooHostedFields';
    }

    public function isValid(): bool
    {
        return false;
    }

    public function isDisabled(): bool
    {
        return true;
    }

    public function getJsData(): array
    {
        return [
            ...parent::getJsData(),
            'jwtToken' => $this->getContext()->getTokenService()->getToken(),
        ];
    }
}
