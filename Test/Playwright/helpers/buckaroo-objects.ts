const {expect} = require(process.cwd() + '/node_modules/@playwright/test');

export class BuckarooPortal {
    page;
    locator;

    constructor(page) {
        this.page = page;
    }

    async expectTestPaymentPage() {
        await expect(this.page).toHaveURL(/pay.buckaroo.nl/, {timeout: 10000});
    }

    async expectTestCheckoutPage() {
        await expect(this.page).toHaveURL(/testcheckout.buckaroo.nl/, {timeout: 10000});
    }
}
