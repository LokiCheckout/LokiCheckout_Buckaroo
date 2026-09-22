import {PaymentMethod, PlaceOrderButton} from '@loki-checkout/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@loki/test';
import merge from '@loki/util/merge';

import {BuckarooPortal} from './helpers/buckaroo-objects';
import buckarooConfig from './config/config';

test.describe('Creditcard payment test', () => {
    const currentConfig = merge(buckarooConfig, {
        catchErrors: false,
        config: {
            'payment/buckaroo_magento2_creditcard/active': 1,
            'payment/buckaroo_magento2_creditcard/allowed_issuers': 'amex,cartebancaire,cartebleuevisa,dankort,maestro,mastercard',
        }
    });

    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_creditcard');
        await paymentMethod.select();

        const form = page.getById('loki-checkout-payment-methods-buckaroo-magento2-creditcard-form-card-type');
        await expect(form).toBeVisible();

        const card = page.getByLabel('American Express');
        await card.check();

        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        const buckarooPortal = new BuckarooPortal(page);
        await buckarooPortal.expectTestPaymentPage();
    });

    test('should fail with empty form', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_creditcard');
        await paymentMethod.select();

        const form = page.getById('loki-checkout-payment-methods-buckaroo-magento2-creditcard-form-card-type');
        await expect(form).toBeVisible();

        await new PlaceOrderButton(page).clickAndFail();

        await page.waitForLoadState('networkidle');
        await expect(form).toHaveText(/Please enter a valid card/);
    });
});
