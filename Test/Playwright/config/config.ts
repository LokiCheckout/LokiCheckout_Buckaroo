import coreConfig from '@loki-checkout/config';
import merge from '@loki/util/merge';

// Values of payment/buckaroo_magento2_*/active (Buckaroo\Magento2\Model\Config\Source\Enablemode).
// The per-method value decides whether Buckaroo runs in test or live mode, so tests must use BUCKAROO_MODE_TEST.
// Note that buckaroo_magento2/account/active is a plain Yes/No flag and does not select the mode.
export const BUCKAROO_MODE_OFF = 0;
export const BUCKAROO_MODE_TEST = 1;
export const BUCKAROO_MODE_LIVE = 2;

const merchantKey: string = process.env.BUCKAROO_MERCHANT_KEY || '';
const secretKey: string = process.env.BUCKAROO_SECRET_KEY || '';

// Buckaroo hides all of its payment methods when no merchant key or secret key is configured,
// so fail loudly instead of silently skipping
export const requireCredentials = (test): void => {
    test.beforeEach(() => {
        if (!merchantKey.trim() || !secretKey.trim()) {
            throw new Error('Missing Buckaroo credentials: BUCKAROO_MERCHANT_KEY and BUCKAROO_SECRET_KEY');
        }
    });
};

export default merge(coreConfig, {
    product: true,
    // The Buckaroo sandbox rejects invoice numbers used before (InvoiceNumberUsedInThePast),
    // while every fresh CI environment restarts its order numbers
    unique_order_ids: true,
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
        // Methods like iDEAL and Riverty only support EUR, while CI installs Magento with USD
        'currency/options/default': 'EUR',
        'currency/options/allow': 'EUR',
        'customer/address/telephone_show': 'opt'
    }
});
