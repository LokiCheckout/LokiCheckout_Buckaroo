# LokiCheckout_Buckaroo

<!-- badges.specs.start -->
![Magento version](https://img.shields.io/badge/Magento-2.4.6%20%7C%202.4.9-orange)
![PHP version](https://img.shields.io/badge/PHP-8.2%E2%80%938.5-777BB4)
![License](https://img.shields.io/badge/License-OSL--3.0-blue)
![Latest Version](https://img.shields.io/packagist/v/loki-checkout/magento2-buckaroo)
<!-- badges.specs.end -->


**This Magento 2 module is an add-on package for adding support for the payment solution of Buckaroo to the LokiCheckout.**

## Installation
Install this package via composer:
```bash
composer require loki-checkout/magento2-buckaroo
```

Next, enable this module:
```bash
bin/magento module:enable LokiCheckout_Buckaroo Buckaroo_Magento2
bin/magento setup:upgrade
```

## Extending payment methods
By default, most payment methods are supported. If a new payment method is added via the `Buckaroo_Magento2` module, it depends on the method whether or not, the `LokiCheckout_Buckaroo` module needs to be extended. If the method deals with a simple redirect, it just works. If additional input fields are required and they don't exist in the Loki Checkout, most likely the error `Structure validation of XML failed. The SOAP request structure does not conform to the specification` is given.

To add additional fields, create a new block `loki-checkout.payment.methods.buckaroo_magento2_FOOBAR.form` in the XML layout, where `buckaroo_magento2_FOOBAR` equals the payment method code. Check the layout file `loki_checkout_block_payment_methods.xml` for more examples.

Make sure the block `loki-checkout.payment.methods.buckaroo_magento2_FOOBAR.form` is registered as a Loki Component via the file `etc/loki_components.xml`. Also create a corresponding Component ViewModel and Component Repository. Note that each alias (`as`) of additional Buckaroo field in the XML layout (see `loki_checkout_block_payment_methods.xml`) - for example `customer_DoB` - corresponds with the property name - for example `customer_DoB` - that is saved to the quote via the `AdditionalInformationRepository` class.

Which fields need to be added? Each payment method is backed by a class in the PHP namespace `Buckaroo\Magento2\Model\Method`. Within such a method class, the XML construction is initiated, giving evidence of what kind of fields are needed. For example, the code segment `$payment->getAdditionalInformation('customer_email')` suggests that a field `customer_email` should be created.

## Error on `Model/Method/Afterpay.php`
```
Deprecated Functionality: str_replace(): Passing null to parameter #3 ($subject) of type array|string is deprecated in vendor/buckaroo/magento2/Model/Method/Afterpay.php on line 823
```

The method `afterpay2` or `afterpay` is deprecated and can not be used under PHP 8.3. This has nothing to do with the LokiCheckout.

## Current status

<!-- badges.test.start -->
![Static Tests](https://img.shields.io/github/actions/workflow/status/LokiCheckout/LokiCheckout_Buckaroo/static-tests.yml?label=static-tests)
![Unit Tests](https://img.shields.io/github/actions/workflow/status/LokiCheckout/LokiCheckout_Buckaroo/unit-tests.yml?label=unit-tests)
![Integration Tests](https://img.shields.io/github/actions/workflow/status/LokiCheckout/LokiCheckout_Buckaroo/integration-tests.yml?label=integration-tests)
![Playwright](https://img.shields.io/github/actions/workflow/status/LokiCheckout/LokiCheckout_Buckaroo/playwright.yml?label=playwright)
![DI Compilation](https://img.shields.io/github/actions/workflow/status/LokiCheckout/LokiCheckout_Buckaroo/compile.yml?label=compile)
<!-- badges.test.end -->
