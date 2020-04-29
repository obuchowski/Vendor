<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Controller\Adminhtml\Vendor;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Obukhovsky\Vendor\Api\Data\VendorInterface;
use Obukhovsky\Vendor\Api\VendorRepositoryInterface;
use Obukhovsky\Vendor\Controller\Adminhtml\Vendor as VendorController;

class Save extends VendorController
{
    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @param Context $context
     * @param VendorRepositoryInterface $vendorRepository
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        VendorRepositoryInterface $vendorRepository,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context, $vendorRepository);
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(): ResultInterface
    {
        $requestData = $this->getRequest()->getPostValue();
        if (!$this->getRequest()->isPost() || empty($requestData)) {
            $this->messageManager->addErrorMessage(__('Wrong request.'));
            return $this->processRedirectAfterFailureSave([]);
        }

        if (empty($requestData[VendorInterface::VENDOR_ID])) {
            $requestData[VendorInterface::VENDOR_ID] = null;
        }

        $vendorId = $requestData[VendorInterface::VENDOR_ID];
        try {
            $vendor = $vendorId ? $this->getVendorRepository()->getById($vendorId) : $this->getVendorRepository()->create();
            $this->processSave($vendor, $requestData);
            $this->messageManager->addSuccessMessage(__('Vendor has been saved'));
            $resultRedirect = $this->processRedirectAfterSuccessSave($vendor->getId());
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect = $this->processRedirectAfterFailureSave($requestData);
        } catch (CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect = $this->processRedirectAfterFailureSave($requestData);
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect = $this->processRedirectAfterFailureSave($requestData);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Could not save Vendor'));
            $resultRedirect = $this->processRedirectAfterFailureSave($requestData);
        }

        return $resultRedirect;
    }

    /**
     * @param VendorInterface $vendor
     * @param array $requestData
     * @return void
     * @throws LocalizedException
     */
    private function processSave(VendorInterface $vendor, array $requestData): void
    {
        $vendor->addData($requestData);
        $this->getVendorRepository()->save($vendor);
        $this->dataPersistor->clear('ob_vendor_vendor');
    }

    /**
     * @param $id
     * @return Redirect
     */
    private function processRedirectAfterSuccessSave($id): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->getRequest()->getParam('back')) {
            $resultRedirect->setPath('*/*/edit', [VendorInterface::VENDOR_ID => $id, '_current' => true]);
        } else {
            $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }

    /**
     * @param array $data
     * @return Redirect
     */
    private function processRedirectAfterFailureSave($data)
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if (empty($data[VendorInterface::VENDOR_ID])) {
            $resultRedirect->setPath('*/*/edit');
        } else {
            $resultRedirect->setPath(
                '*/*/edit',
                [VendorInterface::VENDOR_ID => $data[VendorInterface::VENDOR_ID], '_current' => true]
            );
        }

        if ($data) {
            $this->dataPersistor->set('ob_vendor_vendor', $data);
        }

        return $resultRedirect;
    }
}
