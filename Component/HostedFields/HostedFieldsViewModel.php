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
        return false;
    }

    public function getJsData(): array
    {
        // @todo: implement payment/buckaroo_magento2_creditcards/subtext
        // @todo: payment/buckaroo_magento2_creditcards/subtext_style
        // @todo: payment/buckaroo_magento2_creditcards/subtext_color
        return [
            ...parent::getJsData(),
            'jwtToken' => $this->getContext()->getTokenService()->getToken(),
            'allowedIssuers' => $this->getAllowIssuers(),
        ];
    }

    private function getAllowIssuers(): array
    {
        $defaultIssuers = [
            //'Amex',
            'Mastercard',
            //'Maestro',
            //'Visa'
        ];

        $scopeConfig = $this->getContext()->getScopeConfig();
        $allowedIssuers = trim((string)$scopeConfig->getValue('payment/buckaroo_magento2_creditcards/allowed_issuers'));
        if (empty($allowedIssuers)) {
            return $defaultIssuers;
        }

        return explode(',', $allowedIssuers);
    }
}
