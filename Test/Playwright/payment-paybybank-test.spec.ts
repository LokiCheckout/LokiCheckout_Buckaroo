import {PaymentMethod, PlaceOrderButton, Messages} from '@loki-checkout/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test} from '@loki/test';
import merge from '@loki/util/merge';

import buckarooConfig, {skipWithoutCredentials} from './config/config';

test.describe('PayByBank payment test', () => {
    skipWithoutCredentials(test);

    const currentConfig = merge(buckarooConfig, {
        catchErrors: false,
        config: {
            'payment/buckaroo_magento2_paybybank/active': 1,
        }
    });

    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_paybybank');
        await paymentMethod.select();

        await new PlaceOrderButton(page).click();
        await new Messages(page).expectMessage(/No valid subscription found for service 'paybybank'./i);
    });
});
