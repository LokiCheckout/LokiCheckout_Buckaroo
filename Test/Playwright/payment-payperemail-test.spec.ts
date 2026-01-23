import {PaymentMethod, PlaceOrderButton, SuccessPage} from '@loki/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@loki/test';

import buckarooConfig from './config/config';

test.describe('payperemail payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, {
            ...buckarooConfig,
            config: {
                ...buckarooConfig.config,
                'payment/buckaroo_magento2_payperemail/active': 1,
                'payment/buckaroo_magento2_payperemail/customer_type': 'both',
            }
        });

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_payperemail');
        await paymentMethod.select();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        await new SuccessPage(page).expectToBeLoaded();
    });
});
