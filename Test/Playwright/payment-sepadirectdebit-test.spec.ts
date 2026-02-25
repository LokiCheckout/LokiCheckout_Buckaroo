import {PaymentMethod, PlaceOrderButton} from '@loki/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test} from '@loki/test';
import merge from '@loki/util/merge';

import buckarooConfig from './config/config';

test.describe('sepadirectdebit payment test', () => {
    const currentConfig = merge(buckarooConfig, {
        config: {
            'payment/buckaroo_magento2_sepadirectdebit/active': 1,
        }
    });

    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_sepadirectdebit');
        await paymentMethod.select();

        const accountNameField = await page.getById('loki-checkout-payment-methods-buckaroo-magento2-sepadirectdebit-form-customer-account-name-field');
        await accountNameField.fill('Jisse Reitsma');
        await accountNameField.blur();

        const ibanField = await page.getById('loki-checkout-payment-methods-buckaroo-magento2-sepadirectdebit-form-customer-iban-field');
        await ibanField.fill('NL33 KNAB 0256 9222 41');

        await new PlaceOrderButton(page).clickAndSuccess();
    });

    test('should not allow to proceed with empty form', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_sepadirectdebit');
        await paymentMethod.select();

        await new PlaceOrderButton(page).clickAndFail();
    });
});
