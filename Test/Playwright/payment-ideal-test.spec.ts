import {PaymentMethod, PlaceOrderButton} from '@loki/checkout-objects';
import {BuckarooPortal} from './helpers/buckaroo-objects';

import {setupCheckout} from '@loki/setup-checkout';
import {test} from '@loki/test';
import merge from '@loki/util/merge';

import buckarooConfig from './config/config';

test.describe('iDeal payment test', () => {
    const currentConfig = merge(buckarooConfig, {
        catchErrors: false,
        config: {
            'payment/buckaroo_magento2_ideal/active': 1,
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
