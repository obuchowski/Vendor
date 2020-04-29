<?php

namespace Obukhovsky\Vendor\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface VendorSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get pages list.
     *
     * @return \Obukhovsky\Vendor\Api\Data\VendorInterface[]
     */
    public function getItems();

    /**
     * Set pages list.
     *
     * @param \Obukhovsky\Vendor\Api\Data\VendorInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
