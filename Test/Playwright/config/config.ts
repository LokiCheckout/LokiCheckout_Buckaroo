import coreConfig from '@loki/config';

export default {
    ...coreConfig,
    modules: [
        'LokiCheckout_Buckaroo',
        'Buckaroo_Magento2',
    ],
    config: {
        ...coreConfig.config,
        'buckaroo_magento2/account/active': 1,
    }
};
