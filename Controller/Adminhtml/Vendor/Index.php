<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Controller\Adminhtml\Vendor;

use Magento\Framework\Controller\ResultInterface;
use Obukhovsky\Vendor\Controller\Adminhtml\Vendor;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;

class Index extends Vendor
{
    /**
     * {@inheritDoc}
     */
    public function execute(): ResultInterface
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $this->initPage($resultPage)->addBreadcrumb(__('List'), __('List'));
        $resultPage->getConfig()->getTitle()->prepend(__('Vendors'));
        return $resultPage;
    }
}
