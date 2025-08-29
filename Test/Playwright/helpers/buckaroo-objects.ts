const {expect} = require(process.cwd() + '/node_modules/@playwright/test');

export class BuckarooPortal {
    page;
    locator;

    constructor(page) {
        this.page = page;
    }

    async expectTestPaymentPage() {
        await expect(this.page).toHaveURL(/pay.buckaroo.nl/, {timeout: 10000});

        const body = await this.page.locator('body');
        await expect(body).toHaveText(/Pay Now/);    }

    async expectTestCheckoutPage() {
        await expect(this.page).toHaveURL(/testcheckout.buckaroo.nl/, {timeout: 10000});

        const body = await this.page.locator('body');
        await expect(body).toHaveText(/Select a status for this test transaction and process it accordingly/);
    }
}
