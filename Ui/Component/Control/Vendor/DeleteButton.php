<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Ui\Component\Control\Vendor;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Obukhovsky\Vendor\Api\Data\VendorInterface;

class DeleteButton implements ButtonProviderInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param RequestInterface $request
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        RequestInterface $request,
        UrlInterface $urlBuilder
    ) {
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * {@inheritDoc}
     */
    public function getButtonData(): array
    {
        $data = [];
        $vendorId = $this->request->getParam(VendorInterface::VENDOR_ID);
        if (null !== $vendorId) {
            $confirmationMessage = __('This Vendor will be deleted! Are you sure?');
            $url = $this->urlBuilder->getUrl('*/*/delete');
            $data = [
                'label' => __('Delete'),
                'class' => 'delete action-secondary',
                'on_click' => "deleteConfirm('{$confirmationMessage}', '{$url}', {data:{vendor_id:{$vendorId}}})",
                'sort_order' => 30,
            ];
        }
        return $data;
    }
}
