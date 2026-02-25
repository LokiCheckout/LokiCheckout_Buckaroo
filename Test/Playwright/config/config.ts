import coreConfig from '@loki/config';
import merge from '@loki/util/merge';

export default merge(coreConfig, {
    modules: [
        'LokiCheckout_Buckaroo',
        'Buckaroo_Magento2',
    ],
    config: {
        'buckaroo_magento2/account/active': 1,
        'customer/address/telephone_show': 'opt'
    }
});
