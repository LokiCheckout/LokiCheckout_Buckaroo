<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutBuckaroo\Service;

use Buckaroo\Magento2\Model\ConfigProvider\Method\Creditcards;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use RuntimeException;

class TokenService
{
    public function __construct(
        private Curl $curlClient,
        private Creditcards $configProviderCreditcard,
        private EncryptorInterface $encryptor,
        private StoreManagerInterface $storeManager,
    ) {
    }

    public function getToken(): string
    {
        $hostedFieldsClientId = $this->getHostedFieldsClientId();
        $hostedFieldsClientSecret = $this->getHostedFieldsClientSecret();
        $issuers = $this->getAllowedIssuers();

        if (empty($hostedFieldsClientId) || empty($hostedFieldsClientSecret)) {
            throw new RuntimeException('Hosted Fields Username or Password is empty.');
        }

        if (empty($issuers)) {
            throw new RuntimeException('There is no Allowed Issuers for Hosted Fields.');
        }

        try {
            $url = "https://auth.buckaroo.io/oauth/token";
            $postData = [
                'scope' => 'hostedfields:save',
                'grant_type' => 'client_credentials'
            ];

            $response = $this->sendPostRequest($url, $hostedFieldsClientId, $hostedFieldsClientSecret, $postData);
            $responseArray = json_decode($response, true);

            if (isset($responseArray['access_token'])) {
                // @todo: Save this in session?
                // @todo: What to do with $responseArray['expires_in']
                // @todo: What to do with $issuers
                return $responseArray['access_token'];
            }

            throw new RuntimeException('Error fetching token.');

        } catch (\Exception $e) {
            throw new RuntimeException('An error occurred while fetching the token.');
        }
    }

    private function sendPostRequest($url, $username, $password, $postData)
    {
        try {
            $this->curlClient->setCredentials($username, $password);
            $this->curlClient->addHeader("Content-Type", "application/x-www-form-urlencoded");
            $this->curlClient->post($url, http_build_query($postData));

            return $this->curlClient->getBody();
        } catch (\Exception $e) {
            throw new \Exception('Error occurred during cURL request: '.$e->getMessage());
        }
    }

    private function getHostedFieldsClientId()
    {
        try {
            return $this->encryptor->decrypt(
                $this->configProviderCreditcard->getHostedFieldsClientId()
            );
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getHostedFieldsClientSecret()
    {
        try {
            return $this->encryptor->decrypt(
                $this->configProviderCreditcard->getHostedFieldsClientSecret()
            );
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getAllowedIssuers()
    {
        try {
            return $this->configProviderCreditcard->getSupportedServices();
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getStore(): StoreInterface
    {
        return $this->storeManager->getStore();
    }
}
