<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Controller\Adminhtml\Vendor;

use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Obukhovsky\Vendor\Api\Data\VendorInterface;
use Obukhovsky\Vendor\Controller\Adminhtml\Vendor;

class Edit extends Vendor
{
    /**
     * {@inheritDoc}
     */
    public function execute(): ResultInterface
    {
        $vendorId = $this->getRequest()->getParam(VendorInterface::VENDOR_ID);
        try {
            $vendor = $vendorId
                ? $this->getVendorRepository()->getById($vendorId)
                : $this->getVendorRepository()->create();
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            /** @var Redirect $resultPage */
            $resultPage = $this->resultRedirectFactory->create();
            return $resultPage->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage('Something went wrong');
            /** @var Redirect $resultPage */
            $resultPage = $this->resultRedirectFactory->create();
            return $resultPage->setPath('*/*/');
        }

        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $vendor->getId() ? __('Edit Vendor') : $title = __('New Vendor');
        $this->initPage($resultPage)->addBreadcrumb($title, $title);
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
