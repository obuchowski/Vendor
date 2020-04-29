<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Obukhovsky\Vendor\Model\GetVendorsByProductId;

class Vendor extends AbstractModifier
{
    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @var GetVendorsByProductId
     */
    private $getVendorsByProductId;

    /**
     * @param LocatorInterface $locator
     * @param GetVendorsByProductId $getVendorsByProductId
     */
    public function __construct(
        LocatorInterface $locator,
        GetVendorsByProductId $getVendorsByProductId
    ) {
        $this->locator = $locator;
        $this->getVendorsByProductId = $getVendorsByProductId;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyData(array $data): array
    {
        $productId = (int)$this->locator->getProduct()->getId();
        if ($productId) {
            $vendors = $this->getVendorsByProductId->execute($productId);
            $ids = array_keys($vendors);

            //[1,2,3] doesn't work with UI components. ['1','2','3'] does.
            $idsAsString = array_map(function ($id) {
                return (string) $id;
            }, $ids);
            $data[$productId]['product']['vendor_ids'] = $idsAsString;
        }

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyMeta(array $meta): array
    {
        /** @see view/adminhtml/ui_component/product_form.xml */
        return $meta;
    }
}
