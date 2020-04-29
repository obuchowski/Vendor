<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Ui\DataProvider;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Obukhovsky\Vendor\Model\ResourceModel\Vendor\Collection;
use Obukhovsky\Vendor\Model\ResourceModel\Vendor\CollectionFactory;
use Obukhovsky\Vendor\Model\Vendor;

class VendorDataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var array
     */
    private $loadedData;

    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $pageCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $pageCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $pageCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * {@inheritDoc}
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $this->loadedData = [];
        $items = $this->collection->getItems();
        foreach ($items as $vendor) {
            /** @var Vendor $vendor */
            $this->loadedData[$vendor->getId()] = $vendor->getData();
        }

        $data = $this->dataPersistor->get('ob_vendor_vendor');
        if (!empty($data)) {
            /** @var Vendor $vendor */
            $vendor = $this->collection->getNewEmptyItem()->setData($data);
            $this->loadedData[$vendor->getId()] = $vendor->getData();
            $this->dataPersistor->clear('ob_vendor_vendor');
        }

        return $this->loadedData;
    }
}
