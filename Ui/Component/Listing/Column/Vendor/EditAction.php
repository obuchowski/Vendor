<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Ui\Component\Listing\Column\Vendor;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Obukhovsky\Vendor\Api\Data\VendorInterface;

class EditAction extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * {@inheritDoc}
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item[VendorInterface::VENDOR_ID])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl('vendor/vendor/edit', [
                                VendorInterface::VENDOR_ID => $item[VendorInterface::VENDOR_ID],
                            ]),
                            'label' => __('Edit')
                        ]
                    ];
                    unset($item);
                }
            }
        }

        return $dataSource;
    }
}
