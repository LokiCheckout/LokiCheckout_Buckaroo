import {PaymentMethod, PlaceOrderButton, SuccessPage, Messages} from '@loki/checkout-objects';
import {BuckarooPortal} from './helpers/buckaroo-objects';

import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@loki/test';
import merge from '@loki/util/merge';

import buckarooConfig from './config/config';

test.describe('afterpay20 both payment test', () => {
    const currentConfig = merge(buckarooConfig, {
        config: {
            'payment/buckaroo_magento2_afterpay20/active': 1,
            'payment/buckaroo_magento2_afterpay20/customer_type': 'both',
        }
    });

    test('b2b checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_afterpay20');
        await paymentMethod.select();

        const company = page.getById('loki-checkout-shipping-address-company-field');
        await company.fill('Loki Extensions');
        await company.blur();

        const form = page.getById('loki-checkout-payment-methods-item-buckaroo-magento2-afterpay20-form');
        await expect(form).toBeVisible();

        const dob = page.getByLabel('Date of Birth');
        await expect(dob).toHaveCount(0);

        const coc = page.getByLabel('COC Number');
        await coc.fill('53173163');
        await coc.blur();

        const tac = page.getByLabel('Terms and Conditions');
        await tac.check();
        await tac.blur();

        /*
        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        await new SuccessPage(page).expectToBeLoaded();
         */

        await new PlaceOrderButton(page).click();
        await new Messages(page).expectMessage(/An error occurred while processing the transaction: Authorize rejected/);
    });

    test('b2c checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_afterpay20');
        await paymentMethod.select();

        const company = page.getById('loki-checkout-shipping-address-company-field');
        await company.fill('');
        await company.blur();

        const form = page.getById('loki-checkout-payment-methods-item-buckaroo-magento2-afterpay20-form');
        await expect(form).toBeVisible();

        const dob = page.getByLabel('Date of Birth');
        await dob.fill('1970-01-01');

        const coc = page.getByLabel('COC Number');
        await expect(coc).toHaveCount(0);

        const tac = page.getByLabel('Terms and Conditions');
        await tac.check();
        await tac.blur();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        await new BuckarooPortal(page).expectRivertyPage();
    });

    test('empty phone', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const globalTelephone = page.getById('loki-checkout-shipping-address-telephone-field');
        await globalTelephone.fill('');
        await globalTelephone.blur();

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_afterpay20');
        await paymentMethod.select();

        const form = page.getById('loki-checkout-payment-methods-item-buckaroo-magento2-afterpay20-form');
        await expect(form).toBeVisible();

        const telephone = page.getById('loki-checkout-payment-methods-buckaroo-magento2-afterpay20-form-customer-telephone-field');
        await telephone.fill('1234567890');
        await expect(telephone).toHaveValue('1234567890');
    });
});
