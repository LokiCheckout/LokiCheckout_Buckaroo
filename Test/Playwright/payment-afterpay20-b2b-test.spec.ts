import {PaymentMethod, PlaceOrderButton, SuccessPage, Messages} from '@loki/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@loki/test';
import merge from '@loki/util/merge';

import buckarooConfig from './config/config';

test.describe('afterpay20 b2b payment test', () => {
    const currentConfig = merge(buckarooConfig, {
        config: {
            'payment/buckaroo_magento2_afterpay20/active': 1,
            'payment/buckaroo_magento2_afterpay20/customer_type': 'b2b',
        }
    });

    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_afterpay20');
        await paymentMethod.select();

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
        await new Messages(page).expectMessage('An error occurred while processing the transaction: Authorize rejected');
    });

    test('should not proceed with empty form', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_afterpay20');
        await paymentMethod.select();

        const form = page.getById('loki-checkout-payment-methods-item-buckaroo-magento2-afterpay20-form');
        await expect(form).toBeVisible();

        await new PlaceOrderButton(page).clickAndFail();

        await page.waitForLoadState('networkidle');
        await expect(form).toHaveText(/Please enter a valid CoC number/);
        await expect(form).toHaveText(/Please agree to these terms/);
    });
});
