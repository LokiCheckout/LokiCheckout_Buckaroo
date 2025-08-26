<?php declare(strict_types=1);

namespace LokiCheckout\Buckaroo\Component\Voucher;

use Buckaroo\Magento2\Api\ApplyVoucherInterface;
use Loki\Components\Component\ComponentRepository;

class VoucherRepository extends ComponentRepository
{
    public function __construct(
        private readonly ApplyVoucherInterface $applyVoucher,
    ){
    }

    public function getValue(): mixed
    {
        return null;
    }

    public function saveValue(mixed $value): void
    {
        $this->applyVoucher->apply($value);
    }
}
