<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Obukhovsky\Vendor\Api\Data;
use Obukhovsky\Vendor\Api\Data\VendorInterface;
use Obukhovsky\Vendor\Api\VendorRepositoryInterface;
use Obukhovsky\Vendor\Model\ResourceModel\Vendor as VendorResource;
use Obukhovsky\Vendor\Model\ResourceModel\Vendor\Collection as VendorCollection;
use Obukhovsky\Vendor\Model\ResourceModel\Vendor\CollectionFactory as VendorCollectionFactory;

class VendorRepository implements VendorRepositoryInterface
{
    /**
     * @var VendorResource
     */
    private $resource;

    /**
     * @var VendorFactory
     */
    private $vendorFactory;

    /**
     * @var VendorCollectionFactory
     */
    private $vendorCollectionFactory;

    /**
     * @var SearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param VendorResource $resource
     * @param VendorFactory $vendorFactory
     * @param VendorCollectionFactory $vendorCollectionFactory
     * @param SearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        VendorResource $resource,
        VendorFactory $vendorFactory,
        VendorCollectionFactory $vendorCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->vendorFactory = $vendorFactory;
        $this->vendorCollectionFactory = $vendorCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * {@inheritDoc}
     */
    public function create(): VendorInterface
    {
        return $this->vendorFactory->create();
    }

    /**
     * {@inheritDoc}
     */
    public function getById($vendorId): VendorInterface
    {
        $vendor = $this->create();
        $this->resource->load($vendor, $vendorId);
        if (!$vendor->getId()) {
            throw new NoSuchEntityException(__('The vendor with the "%1" ID doesn\'t exist.', $vendorId));
        }
        return $vendor;
    }

    /**
     * {@inheritDoc}
     */
    public function save(Data\VendorInterface $vendor): VendorInterface
    {
        try {
            $this->resource->save($vendor);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $vendor;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(Data\VendorInterface $vendor): bool
    {
        try {
            $this->resource->delete($vendor);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById($vendorId): bool
    {
        return $this->delete($this->getById($vendorId));
    }

    /**
     * {@inheritDoc}
     */
    public function getList(SearchCriteriaInterface $criteria): SearchResultsInterface
    {
        /** @var VendorCollection $collection */
        $collection = $this->vendorCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var SearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
