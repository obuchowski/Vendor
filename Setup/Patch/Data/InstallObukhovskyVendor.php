<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Setup\Patch\Data;

use Magento\Catalog\Model\Product\Attribute\Source\Status as ProductStatus;
use Magento\Catalog\Model\Product\Visibility as ProductVisibility;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Obukhovsky\Vendor\Api\Data\VendorInterface;
use Obukhovsky\Vendor\Api\VendorRepositoryInterface;
use Obukhovsky\Vendor\Model\ResourceModel\Vendor as ResourceVendor;
use Obukhovsky\Vendor\Model\Vendor;

class InstallObukhovskyVendor implements DataPatchInterface
{
    const PRODUCT_IDS = 'product_ids';

    /**
     * @var State
     */
    private $appState;

    /**
     * @var CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var ProductStatus
     */
    private $productStatus;

    /**
     * @var ProductVisibility
     */
    private $productVisibility;

    /**
     * @var VendorRepositoryInterface
     */
    private $vendorRepository;

    /**
     * @var ResourceVendor
     */
    private $vendorResource;

    /**
     * @param State $appState
     * @param CollectionFactory $productCollectionFactory
     * @param ProductStatus $productStatus
     * @param ProductVisibility $productVisibility
     * @param VendorRepositoryInterface $vendorRepository
     * @param ResourceVendor $vendorResource
     */
    public function __construct(
        State $appState,
        ProductCollectionFactory $productCollectionFactory,
        ProductStatus $productStatus,
        ProductVisibility $productVisibility,
        VendorRepositoryInterface $vendorRepository,
        ResourceVendor $vendorResource
    ) {
        $this->appState = $appState;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        $this->vendorRepository = $vendorRepository;
        $this->vendorResource = $vendorResource;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(): InstallObukhovskyVendor
    {
        $this->appState->emulateAreaCode(Area::AREA_GLOBAL, [$this, 'install']);
        return $this;
    }

    /**
     * @throws LocalizedException
     */
    public function install(): void
    {
        $connection = $this->vendorResource->getConnection();
        $table = $this->vendorResource->getTable('vendor2product');
        $vendors = $this->getVendorsLinkedToRandomVisibleProducts();
        foreach ($vendors as $i => $vendor) {
            /** @var Vendor $vendor */
            if ($vendor->getData(static::PRODUCT_IDS)) {
                $vendor->setName('Vendor #' . ($i + 1));
                $this->vendorRepository->save($vendor);
                $data = [];
                foreach ($vendor->getData(static::PRODUCT_IDS) as $productId) {
                    $data[] = [
                        'product_id' => $productId,
                        'vendor_id' => $vendor->getId()
                    ];
                }
                $connection->insertMultiple($table, $data);
            }
        }
    }

    /**
     * Assign visible products to vendors Assign its children to a corresponding vendor.
     *
     * @return array
     */
    private function getVendorsLinkedToRandomVisibleProducts(): array
    {
        $currentVendor = $this->createVendor();
        $vendors = [$currentVendor];
        foreach ($this->getVisibleProducts() as $product) {
            $ids = [$product->getId()];
            $typeInstance = $product->getTypeInstance();
            $childrenIds = (array)$typeInstance->getChildrenIds($product->getId());
            foreach ($childrenIds as $group) {
                $ids = array_merge($ids, $group);
            }

            $vendorProductIds = array_merge($currentVendor->getData(static::PRODUCT_IDS), $ids);
            $currentVendor->setData(static::PRODUCT_IDS, $vendorProductIds);
            if (count($currentVendor->getData(static::PRODUCT_IDS)) > 50) {
                $currentVendor = $this->createVendor();
                $vendors[] = $currentVendor;
            }
        }

        return $vendors;
    }

    /**
     * @return VendorInterface
     */
    private function createVendor(): VendorInterface
    {
        $vendor = $this->vendorRepository->create();
        $vendor->setData(static::PRODUCT_IDS, []);
        return $vendor;
    }

    /**
     * @return ProductCollection
     */
    private function getVisibleProducts(): ProductCollection
    {
        $collection = $this->productCollectionFactory->create();
        $collection->setVisibility($this->productVisibility->getVisibleInSiteIds());
        $collection->setPageSize(200); //187 for sample data
        $collection->getSelect()->order(new \Zend_Db_Expr('RAND()'));
        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}
