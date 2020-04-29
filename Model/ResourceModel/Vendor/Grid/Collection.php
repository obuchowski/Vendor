<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Model\ResourceModel\Vendor\Grid;

use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Obukhovsky\Vendor\Model\ResourceModel\Vendor\Collection as VendorCollection;
use Psr\Log\LoggerInterface;

class Collection extends VendorCollection implements SearchResultInterface
{
    /**
     * @var AggregationInterface
     */
    private $aggregations;

    /**
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param $mainTable
     * @param $eventPrefix
     * @param $eventObject
     * @param $resourceModel
     * @param string $model
     * @param null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = Document::class,
        $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }

    /**
     * {@inheritDoc}
     */
    public function getAggregations(): array
    {
        return $this->aggregations;
    }

    /**
     * {@inheritDoc}
     */
    public function setAggregations($aggregations): SearchResultInterface
    {
        $this->aggregations = $aggregations;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null): SearchResultInterface
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTotalCount(): int
    {
        return $this->getSize();
    }

    /**
     * {@inheritDoc}
     */
    public function setTotalCount($totalCount): SearchResultInterface
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setItems(array $items = null): SearchResultInterface
    {
        return $this;
    }
}
