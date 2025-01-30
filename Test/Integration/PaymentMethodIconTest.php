<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutBuckaroo\Test\Integration;

use Magento\Framework\App\ObjectManager;
use Magento\TestFramework\Fixture\AppArea;
use PHPUnit\Framework\TestCase;
use Yireo\LokiCheckout\ViewModel\PaymentMethodIcon;

class PaymentMethodIconTest extends TestCase
{
    #[AppArea('frontend')]
    public function testGetIcon()
    {
        $paymentMethodIcon = ObjectManager::getInstance()->get(PaymentMethodIcon::class);
        $icon = $paymentMethodIcon->getIcon('buckaroo_magento2_ideal');
        $this->assertNotEmpty($icon);
    }
}
