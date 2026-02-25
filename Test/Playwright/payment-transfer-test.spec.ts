import {PaymentMethod, PlaceOrderButton} from '@loki/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test} from '@loki/test';
import merge from '@loki/util/merge';

import buckarooConfig from './config/config';

test.describe('bank transfer payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, merge(buckarooConfig, {
            config: {
                'payment/buckaroo_magento2_transfer/active': 1,
            }
        }));

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_transfer');
        await paymentMethod.select();

        await new PlaceOrderButton(page).clickAndSuccess();
    });
});
