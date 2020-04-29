<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Ui\Component\Control\Vendor;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Ui\Component\Control\Container;

class SaveSplitButton implements ButtonProviderInterface
{
    const TARGET_NAME = 'vendor_vendor_form.vendor_vendor_form';

    /**
     * {@inheritDoc}
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save &amp; Continue'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => self::TARGET_NAME,
                                'actionName' => 'save',
                                'params' => [
                                    // first param is redirect flag
                                    false,
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'class_name' => Container::SPLIT_BUTTON,
            'options' => $this->getOptions(),
            'sort_order' => 40,
        ];
    }

    /**
     * @return array
     */
    private function getOptions(): array
    {
        return [
            [
                'label' => __('Save &amp; Back'),
                'data_attribute' => [
                    'mage-init' => [
                        'buttonAdapter' => [
                            'actions' => [
                                [
                                    'targetName' => self::TARGET_NAME,
                                    'actionName' => 'save',
                                    'params' => [
                                        // first param is redirect flag
                                        true,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'sort_order' => 10,
            ]
        ];
    }
}
