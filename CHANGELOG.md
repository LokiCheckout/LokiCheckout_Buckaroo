# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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
