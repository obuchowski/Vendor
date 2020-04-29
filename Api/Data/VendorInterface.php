<?php

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
    public function getId();

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();

    /**
     * Set ID
     *
     * @param int $id
     * @return VendorInterface
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param string $name
     * @return VendorInterface
     */
    public function setName($name);
}
