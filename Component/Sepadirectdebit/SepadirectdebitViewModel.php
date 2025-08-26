<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Sepadirectdebit;

use LokiCheckout\Core\Component\Base\Generic\CheckoutContext;
use LokiCheckout\Core\Component\Base\Payment\AdditionalInformation\AdditionalInformationViewModel;

/**
 * @method CheckoutContext getContext()
 */
class SepadirectdebitViewModel extends AdditionalInformationViewModel
{
    public function isRequired(): bool
    {
        return true;
    }
}
