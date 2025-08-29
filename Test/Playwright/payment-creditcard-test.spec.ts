import {PaymentMethod, PlaceOrderButton} from '@loki/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@loki/test';

import {BuckarooPortal} from './helpers/buckaroo-objects';
import buckarooConfig from './config/config';

test.describe('Creditcard payment test', () => {
    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, {
            ...buckarooConfig,
            config: {
                ...buckarooConfig.config,
                'payment/buckaroo_magento2_creditcard/active': 1,
            }
        });

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_creditcard');
        await paymentMethod.select();

        const card = page.getByLabel('American Express');
        await card.check();
        await card.blur();
        await page.waitForLoadState('networkidle');
        await expect(card).toBeEditable();
        await expect(card).toBeChecked();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        const buckarooPortal = new BuckarooPortal(page);
        await buckarooPortal.expectTestPaymentPage();
    });
});
