import {PaymentMethod, PlaceOrderButton, SuccessPage} from '@loki/checkout-objects';
import {BuckarooPortal} from './helpers/buckaroo-objects';

import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@loki/test';
import merge from '@loki/util/merge';

import buckarooConfig from './config/config';

test.describe('afterpay20 b2c payment test', () => {
    const currentConfig = merge(buckarooConfig, {
        config: {
            'payment/buckaroo_magento2_afterpay20/active': 1,
            'payment/buckaroo_magento2_afterpay20/customer_type': 'b2c',
        }
    });

    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_afterpay20');
        await paymentMethod.select();

        const form = page.getById('loki-checkout-payment-methods-item-buckaroo-magento2-afterpay20-form');
        await expect(form).toBeVisible();

        const coc = page.getByLabel('COC Number');
        await expect(coc).toHaveCount(0);

        const dob = page.getByLabel('Date of Birth');
        await dob.fill('1970-01-01');
        await dob.blur();

        const tac = page.getByLabel('Terms and Conditions');
        await tac.check();
        await tac.blur();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        await new BuckarooPortal(page).expectRivertyPage();
    });

    test('should not proceed with empty form', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_afterpay20');
        await paymentMethod.select();

        const form = page.getById('loki-checkout-payment-methods-item-buckaroo-magento2-afterpay20-form');
        await expect(form).toBeVisible();

        await new PlaceOrderButton(page).clickAndFail();

        await page.waitForLoadState('networkidle');
        await expect(form).toHaveText(/Please enter a valid date of birth/);
        await expect(form).toHaveText(/Please agree to these terms/);
    });
});
