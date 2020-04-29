<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Block;

use Magento\Catalog\Block\Product\View\Description as ProductDescription;
use Magento\Framework\Exception\LocalizedException;
use Obukhovsky\Vendor\Model\GetVendorsByProductId;
use Obukhovsky\Vendor\Api\Data\VendorInterface;

class ProductVendors extends ProductDescription
{
    /**
     * @var GetVendorsByProductId
     */
    private $getVendorsByProductId;

    /**
     * @var VendorInterface[]
     */
    private $vendors;

    /**
     * @return GetVendorsByProductId
     * @throws LocalizedException
     */
    private function getGetVendorsByProductId(): GetVendorsByProductId
    {
        if (!$this->getVendorsByProductId) {
            $this->getVendorsByProductId = $this->getData('ob_vendor_get_vendors_by_id');
            if (!$this->getVendorsByProductId instanceof GetVendorsByProductId) {
                throw new LocalizedException(__('Vendors getter is not provided.'));
            }

        }

        return $this->getVendorsByProductId;
    }

    /**
     * @return VendorInterface[]
     * @throws LocalizedException
     */
    public function getVendors()
    {
        if (null === $this->vendors) {
            $productId = (int)$this->getProduct()->getId();
            $this->vendors = $this->getGetVendorsByProductId()->execute($productId);
        }

        return $this->vendors;
    }

    /**
     * {@inheritDoc}
     */
    protected function _toHtml(): string
    {
        if ($this->getVendors()) {
            return parent::_toHtml();
        }

        return '';
    }
}
