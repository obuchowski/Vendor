<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;
use Magento\Framework\Data\Collection\AbstractDb;

class VendorProductFilter implements CustomFilterInterface
{
    /**
     * {@inheritDoc}
     */
    public function apply(Filter $filter, AbstractDb $collection): bool
    {
        /** @var \Obukhovsky\Vendor\Model\ResourceModel\Vendor\Collection $collection */
        $collection->addProductFilter((int)$filter->getValue());
        return true;
    }
}
