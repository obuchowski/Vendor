<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Controller\Adminhtml\Vendor;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Obukhovsky\Vendor\Api\Data\VendorInterface;
use Obukhovsky\Vendor\Controller\Adminhtml\Vendor;

class Delete extends Vendor
{
    /**
     * {@inheritDoc}
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');
        $vendorId =  $this->getRequest()->getPost(VendorInterface::VENDOR_ID);
        if ($vendorId) {
            try {
                $this->getVendorRepository()->deleteById($vendorId);
                $this->messageManager->addSuccessMessage(__('Vendor has been deleted'));
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Could not delete Vendor'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Vendor Id wasn\'t provided'));
        }

        return $resultRedirect;
    }
}
