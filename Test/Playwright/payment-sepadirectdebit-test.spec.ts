import {PaymentMethod, PlaceOrderButton, SuccessPage} from '@loki/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@loki/test';

import buckarooConfig from './config/config';

test.describe('sepadirectdebit payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, {
            ...buckarooConfig,
            config: {
                ...buckarooConfig.config,
                'payment/buckaroo_magento2_sepadirectdebit/active': 1,
            }
        });

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_sepadirectdebit');
        await paymentMethod.select();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        await new SuccessPage(page).expectToBeLoaded();
    });
});
