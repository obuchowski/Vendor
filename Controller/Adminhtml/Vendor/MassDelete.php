<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Controller\Adminhtml\Vendor;

use Obukhovsky\Vendor\Model\ResourceModel\Vendor\Collection as VendorCollection;

class MassDelete extends MassAbstract
{
    /**
     * {@inheritDoc}
     */
    protected function action(VendorCollection $collection): MassAbstract
    {
        $size = $collection->getSize();
        foreach ($collection as $vendor) {
            $this->getVendorRepository()->delete($vendor);
        }
        $this->messageManager->addSuccessMessage(__('%1 Vendor(s) were deleted', $size));
        return $this;
    }
}
