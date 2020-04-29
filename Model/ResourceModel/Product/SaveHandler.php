<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Model\ResourceModel\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Obukhovsky\Vendor\Model\ResourceModel\Vendor;

class SaveHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    private $metadataPool;

    /**
     * @var Vendor
     */
    private $resourceVendor;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param RequestInterface $request
     * @param MetadataPool $metadataPool
     * @param Vendor $resourceVendor
     */
    public function __construct(
        RequestInterface $request,
        MetadataPool $metadataPool,
        Vendor $resourceVendor
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourceVendor = $resourceVendor;
        $this->request = $request;
    }

    /**
     * @param object $product
     * @param array $arguments
     * @return ProductInterface
     * @throws \Exception
     */
    public function execute($product, $arguments = [])
    {
        /** @var ProductInterface $product */
        $data = $this->request->getParam('product');
        if ($product->getData('vendor_ids') || array_key_exists('vendor_ids', $data)) {
            $vendors = array_filter((array)$product->getData('vendor_ids'));
            $connection = $this->resourceVendor->getConnection();
            $table = $this->resourceVendor->getTable('vendor2product');
            $entityMetadata = $this->metadataPool->getMetadata(ProductInterface::class);
            $linkField = $entityMetadata->getLinkField();

            $connection->delete($table, 'product_id = ' . $product->getData($linkField));
            if ($vendors) {
                $data = [];
                foreach ($vendors as $vendorId) {
                    $data[] = [
                        'product_id' => $product->getData($linkField),
                        'vendor_id' => $vendorId
                    ];
                }
                $connection->insertMultiple($table, $data);
            }
        }

        return $product;
    }
}
