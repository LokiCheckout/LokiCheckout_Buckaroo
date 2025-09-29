# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.11] - 29 September 2025
### Fixed
- Sort entries of module.xml file
- Sort dependencies of composer.json
- Copy generic CI/CD files
- Update MODULE.json
- Update README
- Add escaping

## [2.0.10] - 24 September 2025
### Fixed
- Implement new imageRenderer
- Change containers into blocks to allow for caching
- Rename loki-components to loki.script.component

## [2.0.9] - 16 September 2025
### Fixed
- Additional margins for subforms

## [2.0.8] - 03 September 2025
### Fixed
- Copy generic CI/CD files
- Remove unwanted CSS

## [2.0.7] - 02 September 2025
### Fixed
- Add PHPUnit 10 file

## [2.0.6] - 02 September 2025
### Fixed
- Change loki-checkout.payment.payment-methods to loki-checkout.payment.methods
- Refresh payment methods when company or country changes
- Refresh Afterpay form when changing company or country ID
- Refactor hard-coded field attributes to FieldViewModel::getFieldAttributes()
- Conditionally show props in sidebar
- Add Playwright tests
- Refactor Loki-library location in Playwright tests

## [2.0.5] - 29 August 2025
### Fixed
- Add logic to show relevant afterpay20 fields depending on customer type (b2c, b2b)

## [2.0.4] - 27 August 2025
### Fixed
- Add COC Number to afterpay20
- Change CSS scope from `@todo` to block
- Add translations
- Replace yireo/opensearch with yireo/opensearch-dummy in Gitlab CI
- Add Paybybank
- Add concept of Buckaroo Voucher

## [2.0.3] - 26 August 2025
### Fixed
- Disable Hosted Fields because they do not work yet
- Set maximum age of today
- Add support for Alpine Mask config via XML layout
- Fix terms text translation
- Make date of birth configurable
- Add validators for afterpay
- Make sure all fields are required
- Refactor Afterpay form to separate components
- Add new fields for afterpay and afterpay2 method
- Lazyload hosted fields SDK
- Add selection of card type for creditcard method
- Add GitLab CI files
- Prevent errors if `Buckaroo_Magento2` is disabled by using DI proxies
- Add additional exception if `Buckaroo_Magento2` is disabled

## [2.0.2] - 21 August 2025
### Fixed
- Add dependency with loki/magento2-css-utils
- Replace LokiComponentsUtilBlockCssClass with LokiCssUtilsUtilCssClass
- Fix newlines after comments
- Declare used PHP namespaces
- Add escaping of template code
- Document latest version of template
- Add missing `strict_types` declaration
- Lower requirements to PHP 8.1

## [2.0.1] - 07 August 2025
### Fixed
- Lower PHP requirement to PHP 8.2+

## [1.0.1] - 26 May 2025
### Fixed
- Better support for images
- Search for view/frontend icons as well
- Fix issues with redirect to portal

## [0.0.2] - 25 April 2025
### Fixed
- Allow upgrading to LokiFieldComponents and LokiCheckout 1.0

## [0.0.1] - 21 January 2025
- Initial release
