const {expect} = require(process.cwd() + '/node_modules/@playwright/test');

export class BuckarooPortal {
    page;
    locator;

    constructor(page) {
        this.page = page;
    }

    async expectTestPaymentPage() {
        await this.expectUrl(/pay.buckaroo.nl/);
    }

    async expectTestCheckoutPage() {
        await this.expectUrl(/testcheckout.buckaroo.nl/);
    }

    async expectRivertyPage() {
        await this.expectUrl(/riverty.io/);
    }

    async expectSuccessPage() {
        await this.expectUrl(/checkout\/onepage\/success/);
    }

    // When placing the order fails, the checkout is reloaded with an error message, so include that message
    async expectUrl(pattern: RegExp) {
        try {
            await expect(this.page).toHaveURL(pattern, {timeout: 10000});
        } catch (error) {
            const messages = await this.page.locator('[x-data="LokiMessagesComponent"]')
                .textContent({timeout: 1000})
                .catch(() => '');
            throw new Error(error.message + '\nCheckout messages: ' + (messages || '').replace(/\s+/g, ' ').trim());
        }
    }
}
