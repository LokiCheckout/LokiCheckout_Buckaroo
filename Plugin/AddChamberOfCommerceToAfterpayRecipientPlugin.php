<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Plugin;

use Buckaroo\Magento2\Gateway\Request\Recipient\AfterpayDataBuilder;
use Buckaroo\Resources\Constants\RecipientCategory;
use Magento\Payment\Gateway\Helper\SubjectReader;

/**
 * Buckaroo sends the CoC number of a B2B recipient as "identificationNumber", while the Buckaroo SDK
 * only maps "chamberOfCommerce" of a company recipient to the IdentificationNumber that Riverty requires
 */
class AddChamberOfCommerceToAfterpayRecipientPlugin
{
    public function afterBuild(AfterpayDataBuilder $subject, array $result, array $buildSubject): array
    {
        if (($result['recipient']['category'] ?? '') !== RecipientCategory::COMPANY) {
            return $result;
        }

        if (!empty($result['recipient']['chamberOfCommerce'])) {
            return $result;
        }

        $payment = SubjectReader::readPayment($buildSubject)->getPayment();
        $chamberOfCommerce = (string)$payment->getAdditionalInformation('customer_coc');
        if (empty($chamberOfCommerce)) {
            $chamberOfCommerce = (string)$payment->getAdditionalInformation('customer_identificationNumber');
        }

        if (!empty($chamberOfCommerce)) {
            $result['recipient']['chamberOfCommerce'] = $chamberOfCommerce;
        }

        return $result;
    }
}
