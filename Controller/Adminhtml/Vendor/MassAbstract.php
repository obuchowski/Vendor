<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Controller\Adminhtml\Vendor;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Obukhovsky\Vendor\Api\VendorRepositoryInterface;
use Obukhovsky\Vendor\Controller\Adminhtml\Vendor;
use Obukhovsky\Vendor\Model\ResourceModel\Vendor\Collection as VendorCollection;
use Obukhovsky\Vendor\Model\ResourceModel\Vendor\CollectionFactory;

abstract class MassAbstract extends Vendor
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param Context $context
     * @param VendorRepositoryInterface $bendorRepository
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        VendorRepositoryInterface $bendorRepository,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context, $bendorRepository);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(): ResultInterface
    {
        try {
            /** @var VendorCollection $collection */
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $this->action($collection);
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong'));
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param VendorCollection $collection
     * @return MassAbstract
     */
    abstract protected function action(VendorCollection $collection): MassAbstract;
}
