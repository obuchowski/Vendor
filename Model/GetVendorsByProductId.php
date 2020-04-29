<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Model;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Block\ArgumentInterface as BlockArgumentInterface;
use Obukhovsky\Vendor\Api\Data\VendorInterface;
use Obukhovsky\Vendor\Api\VendorRepositoryInterface;

class GetVendorsByProductId implements BlockArgumentInterface
{
    /**
     * @var VendorRepositoryInterface
     */
    private $vendorRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param VendorRepositoryInterface $vendorRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        VendorRepositoryInterface $vendorRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->vendorRepository = $vendorRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param int $productId
     * @return VendorInterface[]
     * @throws LocalizedException
     */
    public function execute($productId)
    {
        $this->searchCriteriaBuilder->addFilter('product_id', $productId);
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $searchResults = $this->vendorRepository->getList($searchCriteria);
        return $searchResults->getItems();
    }
}
