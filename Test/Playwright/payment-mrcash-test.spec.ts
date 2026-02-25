import {PaymentMethod, PlaceOrderButton} from '@loki/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test} from '@loki/test';
import merge from '@loki/util/merge';

import buckarooConfig from './config/config';
import {BuckarooPortal} from "./helpers/buckaroo-objects";

test.describe('Bancontact / Mr Cash payment test', () => {
    const currentConfig = merge(buckarooConfig, {
        catchErrors: false,
        config: {
            'payment/buckaroo_magento2_mrcash/active': 1,
        }
    });

    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_mrcash');
        await paymentMethod.select();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        const buckarooPortal = new BuckarooPortal(page);
        await buckarooPortal.expectTestPaymentPage();
    });
});
