# Yireo_LokiCheckoutBuckaroo

**This is an add-on package for adding support for the payment solution of Buckaroo to the LokiCheckout.**

## Installation
Install this package via composer (assuming you have setup the `composer.yireo.com` repository correctly already):
```bash
composer require yireo/magento2-loki-checkout-buckaroo
```

Next, enable this module:
```bash
bin/magento module:enable Yireo_LokiCheckoutBuckaroo Buckaroo_Magento2
bin/magento setup:upgrade
```

