<?php

declare(strict_types=1);

namespace Obukhovsky\Vendor\Api\Data;

interface VendorInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const VENDOR_ID = 'vendor_id';
    const NAME = 'name';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set ID
     *
     * @param int $id
     * @return VendorInterface
     */
    public function setId($id): VendorInterface;

    /**
     * Set name
     *
     * @param string $name
     * @return VendorInterface
     */
    public function setName($name): VendorInterface;
}
