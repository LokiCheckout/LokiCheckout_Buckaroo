import {PaymentMethod, PlaceOrderButton} from '@loki-checkout/checkout-objects';
import {BuckarooPortal} from './helpers/buckaroo-objects';

import {setupCheckout} from '@loki/setup-checkout';
import {test} from '@loki/test';
import merge from '@loki/util/merge';

import buckarooConfig, {BUCKAROO_MODE_TEST, requireCredentials} from './config/config';

test.describe('iDeal payment test', () => {
    requireCredentials(test);

    const currentConfig = merge(buckarooConfig, {
        catchErrors: false,
        config: {
            'payment/buckaroo_magento2_ideal/active': BUCKAROO_MODE_TEST,
        }
    });

    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_ideal');
        await paymentMethod.select();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        const buckarooPortal = new BuckarooPortal(page);
        await buckarooPortal.expectTestCheckoutPage();
    });
});
