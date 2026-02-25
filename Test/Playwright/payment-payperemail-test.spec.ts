import {PaymentMethod, PlaceOrderButton} from '@loki/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@loki/test';
import merge from '@loki/util/merge';

import buckarooConfig from './config/config';

test.describe('payperemail payment test', () => {
    const currentConfig = merge(buckarooConfig, {
        config: {
            'payment/buckaroo_magento2_payperemail/active': 1,
            'payment/buckaroo_magento2_payperemail/customer_type': 'both',
        }
    });

    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_payperemail');
        await paymentMethod.select();

        await new PlaceOrderButton(page).clickAndSuccess();
    });

    test('should show error in form', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_payperemail');
        await paymentMethod.select();

        const firstnameField = await page.getById('loki-checkout-payment-methods-buckaroo-magento2-payperemail-form-customer-billingfirstname-field');
        await firstnameField.fill('');
        await expect(firstnameField).toHaveValue('');

        await new PlaceOrderButton(page).clickAndFail();
    });
});
