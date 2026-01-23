<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Payperemail;

use LokiCheckout\Core\Component\Base\Payment\AdditionalInformation\AdditionalInformationRepository;

class PayperemailRepository extends AdditionalInformationRepository
{
    public function getDefaultValue(): mixed
    {
        $properyName = $this->getPropertyName();
        $quote = $this->getContext()->getQuote();

        if ($properyName === 'customer_email') {
            return $quote->getCustomerEmail();
        }

        if ($properyName === 'customer_billingFirstName') {
            return $quote->getBillingAddress()->getFirstname();
        }

        if ($properyName === 'customer_billingMiddleName') {
            return $quote->getBillingAddress()->getMiddlename();
        }

        if ($properyName === 'customer_billingLastName') {
            return $quote->getBillingAddress()->getLastname();
        }

        return parent::getDefaultValue();
    }
}
