import {PaymentMethod, PlaceOrderButton, SuccessPage} from '@loki/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@loki/test';

import {BuckarooPortal} from './helpers/buckaroo-objects';
import buckarooConfig from './config/config';

test.describe('afterpay20 payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, {
            ...buckarooConfig,
            config: {
                ...buckarooConfig.config,
                'payment/buckaroo_magento2_afterpay20/active': 1,
                'payment/buckaroo_magento2_afterpay20/customer_type': 'both',
            }
        });

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_afterpay20');
        await paymentMethod.select();

        const coc = page.getByLabel('KVK nummer');
        await coc.fill('53173163');
        await coc.blur();
        await page.waitForLoadState('networkidle');
        await expect(coc).toBeEditable();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        await new SuccessPage(page).expectToBeLoaded();
    });
});
