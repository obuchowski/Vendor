<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Obukhovsky\Vendor\Api\Data\VendorInterface;

class Vendor extends AbstractDb
{
    /**
     * {@inheritDoc}
     */
    public function _construct()
    {
        $this->_init('vendor', VendorInterface::VENDOR_ID);
    }


}
