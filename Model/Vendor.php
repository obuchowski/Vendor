<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Model;

use Magento\Framework\Model\AbstractModel;
use Obukhovsky\Vendor\Api\Data\VendorInterface;
use Obukhovsky\Vendor\Model\ResourceModel\Vendor as VendorResource;

class Vendor extends AbstractModel implements VendorInterface
{
    /**
     * {@inheritDoc}
     */
    public function _construct()
    {
        $this->_init(VendorResource::class);
    }

    /**
     * {@inheritDoc}
     */
    public function getId(): ?int
    {
        return (int)$this->getData(self::VENDOR_ID) ?: null;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id): VendorInterface
    {
        return $this->setData(self::VENDOR_ID, $id);
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name): VendorInterface
    {
        return $this->setData(self::NAME, $name);
    }
}
