<?php

namespace Obukhovsky\Vendor\Api;

interface VendorRepositoryInterface
{
    /**
     * Create new Vendor
     *
     * @return \Obukhovsky\Vendor\Api\Data\VendorInterface
     */
    public function create();

    /**
     * Save vendor.
     *
     * @param \Obukhovsky\Vendor\Api\Data\VendorInterface $vendor
     * @return \Obukhovsky\Vendor\Api\Data\VendorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Obukhovsky\Vendor\Api\Data\VendorInterface $vendor);

    /**
     * Retrieve vendor.
     *
     * @param int $vendorId
     * @return \Obukhovsky\Vendor\Api\Data\VendorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($vendorId);

    /**
     * Delete vendor.
     *
     * @param \Obukhovsky\Vendor\Api\Data\VendorInterface $vendor
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Obukhovsky\Vendor\Api\Data\VendorInterface $vendor);

    /**
     * Delete vendor by ID.
     *
     * @param int $vendorId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($vendorId);

    /**
     * Retrieve vendors matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Obukhovsky\Vendor\Api\Data\VendorSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
