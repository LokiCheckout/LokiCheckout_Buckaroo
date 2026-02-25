import {PaymentMethod, PlaceOrderButton, Messages} from '@loki/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test, expect} from '@loki/test';
import merge from '@loki/util/merge';

//import {BuckarooPortal} from './helpers/buckaroo-objects';
import buckarooConfig from './config/config';

test.describe('PayByBank payment test', () => {
    const currentConfig = merge(buckarooConfig, {
        catchErrors: false,
        config: {
            'payment/buckaroo_magento2_paybybank/active': 1,
        }
    });

    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_paybybank');
        await paymentMethod.select();

        const form = page.getById('loki-checkout-payment-methods-buckaroo-magento2-paybybank-form-issuer');
        await expect(form).toBeVisible();

        const bank = page.getByLabel('ABN AMRO');
        await bank.check();

        /*
        const placeOrderButton = new PlaceOrderButton(page);
        await placeOrderButton.click();

        const buckarooPortal = new BuckarooPortal(page);
        await buckarooPortal.expectTestPaymentPage();
         */

        await new PlaceOrderButton(page).click();
        await new Messages(page).expectMessage(/No valid subscription found for service 'paybybank'./);
    });

    test('should fail with empty form', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const paymentMethod = new PaymentMethod(page, 'buckaroo_magento2_paybybank');
        await paymentMethod.select();

        const form = page.getById('loki-checkout-payment-methods-buckaroo-magento2-paybybank-form-issuer');
        await expect(form).toBeVisible();

        await new PlaceOrderButton(page).clickAndFail();
        await expect(form).toHaveText(/Please select your bank/);
    });
});
