<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page as PageResult;
use Obukhovsky\Vendor\Api\VendorRepositoryInterface;

abstract class Vendor extends Action
{
    const ADMIN_RESOURCE = 'Obukhovsky_Vendor::vendor';

    /**
     * @var VendorRepositoryInterface
     */
    private $vendorRepository;

    /**
     * @param Context $context
     * @param VendorRepositoryInterface $vendorRepository
     */
    public function __construct(
        Context $context,
        VendorRepositoryInterface $vendorRepository
    ) {
        parent::__construct($context);
        $this->vendorRepository = $vendorRepository;
    }

    /**
     * @return VendorRepositoryInterface
     */
    protected function getVendorRepository(): VendorRepositoryInterface
    {
        return $this->vendorRepository;
    }

    /**
     * @param PageResult $resultPage
     * @return PageResult
     */
    protected function initPage(PageResult $resultPage): PageResult
    {
        $breadcrumb = __('Vendors');
        $resultPage->setActiveMenu('Obukhovsky_Vendors::vendor')->addBreadcrumb($breadcrumb, $breadcrumb);
        return $resultPage;
    }
}
