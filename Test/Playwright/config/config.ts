import coreConfig from '@loki/config';
import merge from '@loki/util/merge';

const additionalSettings = JSON.parse(process.env.ADDITIONAL_SETTINGS || '{}');
const merchantKey: string = additionalSettings.BUCKAROO_MERCHANT_KEY || process.env.BUCKAROO_MERCHANT_KEY || '';
const secretKey: string = additionalSettings.BUCKAROO_SECRET_KEY || process.env.BUCKAROO_SECRET_KEY || '';

// Buckaroo hides all of its payment methods when no merchant key or secret key is configured
export const skipWithoutCredentials = (test): void => {
    test.skip(
        !merchantKey.trim() || !secretKey.trim(),
        'Missing Buckaroo credentials: BUCKAROO_MERCHANT_KEY and BUCKAROO_SECRET_KEY (in ADDITIONAL_SETTINGS)'
    );
};

export default merge(coreConfig, {
    product: true,
    modules: [
        'LokiCheckout_Buckaroo',
        'Buckaroo_Magento2',
    ],
    secure_config: {
        'buckaroo_magento2/account/merchant_key': merchantKey,
        'buckaroo_magento2/account/secret_key': secretKey,
    },
    config: {
        'buckaroo_magento2/account/active': 1,
        'customer/address/telephone_show': 'opt'
    }
});
