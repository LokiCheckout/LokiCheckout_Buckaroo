<?php
declare(strict_types=1);

namespace LokiCheckout\Buckaroo\ViewModel\OptionModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Loki\Components\Component\ComponentViewModelInterface;
use Loki\Field\Util\OptionModelInterface;

class GenderOptionModel implements ArgumentInterface, OptionModelInterface
{
    public function getOptions(ComponentViewModelInterface $viewModel): array
    {
        return $this->getAllOptions();
    }

    public function getAllOptions(): array
    {
        return [
            '1' => __('Mr.'),
            '2' => __('Mrs.'),
            '0' => __('They/them'),
            '9' => __('Not applicable'),
        ];
    }
}
