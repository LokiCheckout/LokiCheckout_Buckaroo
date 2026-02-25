import {Field} from '@loki/checkout-objects';
import {setupCheckout} from '@loki/setup-checkout';
import {test} from '@loki/test';
import buckarooConfig from './config/config';
import merge from '@loki/util/merge';

test.describe('LokiCheckout_Buckaroo test', () => {
    const currentConfig = merge(buckarooConfig, {
        config: {
            'payment/buckaroo_magento2_ideal/active': 1,
        }
    });

    test('should allow me to go to the checkout', async ({page, context}) => {
        await setupCheckout(page, context, currentConfig);

        const fields = {
            'shipping.country_id': 'NL',
        };

        for (const [fieldName, fieldValue] of Object.entries(fields)) {
            const field = new Field(page, fieldName);
            await field.fill(fieldValue);
            await field.expectValue(fieldValue);
        }

        await page.locator('//input[@value="buckaroo_magento2_ideal"]').check();
    });
});
