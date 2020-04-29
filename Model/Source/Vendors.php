<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Obukhovsky\Vendor\Api\VendorRepositoryInterface;

class Vendors implements OptionSourceInterface
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
     */
    public function __construct(
        VendorRepositoryInterface $vendorRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->vendorRepository = $vendorRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return array[]
     * @throws LocalizedException
     */
    public function toOptionArray(): array
    {
        $options = [];
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $vendorList = $this->vendorRepository->getList($searchCriteria);
        foreach ($vendorList->getItems() as $vendor) {
            $options[] = [
                'value' => $vendor->getId(),
                'label' => $vendor->getName()
            ];
        }

        return $options;
    }
}
