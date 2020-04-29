<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Model\ResourceModel\Vendor;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Obukhovsky\Vendor\Api\Data\VendorInterface;
use Obukhovsky\Vendor\Model\ResourceModel\Vendor as VendorResource;
use Obukhovsky\Vendor\Model\Vendor;

class Collection extends AbstractCollection
{
    /**
     * {@inheritDoc}
     */
    public function _construct()
    {
        $this->_idFieldName = VendorInterface::VENDOR_ID;
        $this->_eventPrefix = 'ob_vendor_vendor_collection';
        $this->_eventObject = 'ob_vendor_vendor_collection';
        $this->_init(Vendor::class, VendorResource::class);
    }

    /**
     * @param int $productId
     * @return $this
     */
    public function addProductFilter(int $productId): Collection
    {
        $this->addFilter('product_id', $productId);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function _renderFiltersBefore(): void
    {
        $linkField = VendorInterface::VENDOR_ID;
        if ($this->getFilter('product_id')) {
            $this->getSelect()->join(
                ['product_table' => $this->getTable('vendor2product')],
                'main_table.' . $linkField . ' = product_table.' . $linkField,
                []
            );
        }

        parent::_renderFiltersBefore();
    }
}
