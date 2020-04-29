<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Model;

use Obukhovsky\Vendor\Api\Data\VendorSearchResultInterface;
use Magento\Framework\Api\SearchResults;

class VendorSearchResults extends SearchResults implements VendorSearchResultInterface
{
}
