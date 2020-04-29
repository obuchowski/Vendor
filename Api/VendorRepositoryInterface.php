<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Obukhovsky\Vendor\Api\Data\VendorInterface;

interface VendorRepositoryInterface
{

    /**
     * Create new Vendor
     *
     * @return VendorInterface
     */
    public function create(): VendorInterface;
    /**
     * Save vendor.
     *
     * @param VendorInterface $vendor
     * @return VendorInterface
     * @throws LocalizedException
     */
    public function save(Data\VendorInterface $vendor): VendorInterface;

    /**
     * Retrieve vendor.
     *
     * @param int $vendorId
     * @return VendorInterface
     * @throws LocalizedException
     */
    public function getById($vendorId): VendorInterface;

    /**
     * Delete vendor.
     *
     * @param VendorInterface $vendor
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(Data\VendorInterface $vendor): bool;

    /**
     * Delete vendor by ID.
     *
     * @param int $vendorId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($vendorId): bool;

    /**
     * Retrieve vendors matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;
}
