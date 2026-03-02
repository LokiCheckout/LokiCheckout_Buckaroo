# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.21] - 02 March 2026
### Fixed
- Add integration flag to MODULE.json
- Do not add debug info to non-Buckaroo orders
- Add composer patch file

## [2.0.20] - 25 February 2026
### Fixed
- Add dep with quote module
- Add proper Playwright tests for all supported methods
- Add better error messages to paybybank and creditcard
- When modifying telephone, refresh payment methods (because of afterpay)
- Do not make Sepadirectdebit required as a whole, because there are subfields instead
- Fix afterpay20 logic for customer-type `both`
- Restructure XML layout for better management
- Cleanup required duplicate flag for Afterpay
- Hosted fields subform as required
- Improve error message of no card selected
- Make creditcard subselection required again

## [2.0.19] - 13 February 2026
### Fixed
- Add proper error handling when value is required but empty

## [2.0.18] - 23 January 2026
### Fixed
- New Playwright tests
- Remove debugging from last name

## [2.0.17] - 12 January 2026
### Fixed
- Add new GitHub Action workflows

## [2.0.16] - 19 December 2025
### Fixed
- Allow for default Payperemail values from quote
- Render chosen gender in sidebar

## [2.0.15] - 17 December 2025
### Fixed
- Cleanup ViewModels require-flag which now defaults to true
- Render payperemail details in sidebar
- Add payperemail method
- Add new gender options for payperemail
- Add instructions on missing payment methods
- Update composer keywords
- Update composer keywords
- Update composer keywords

## [2.0.14] - 22 October 2025
### Fixed
- Do not escape `$css()` with `escapeHtmlAttr()` but `escapeHtml()`
- Fix merge conflict in templates

## [2.0.13] - 14 October 2025
### Fixed
- Conditionally add all hosted field blocks
- Add `loki_checkout_payment_before_save_quote` event for additional information

## [2.0.12] - 01 October 2025
### Fixed
- Simplify image rendering

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
