import {PaymentMethod, PlaceOrderButton, Messages} from '@loki-checkout/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test} from '@loki/test';
import merge from '@loki/util/merge';

import buckarooConfig, {BUCKAROO_MODE_TEST, requireCredentials} from './config/config';

test.describe('PayByBank payment test', () => {
    requireCredentials(test);

    const currentConfig = merge(buckarooConfig, {
        catchErrors: false,
        config: {
            'payment/buckaroo_magento2_paybybank/active': BUCKAROO_MODE_TEST,
        }
    });

    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_paybybank');
        await paymentMethod.select();

        await new PlaceOrderButton(page).click();
        // Quotes might be HTML-escaped depending on how the Loki_Base version renders messages
        await new Messages(page).expectMessage(/No valid subscription found for service (&#039;|')paybybank(&#039;|')/i);
    });
});
