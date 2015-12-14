<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

use Atanor\Di\Graph\Ghost\Ghost;

interface StorageProvider
{
    const PARAM_VALUE = 'value';

    /**
     * Returns true if ghost has been materialized
     * @return bool
     */
    public function hasStoredValue():bool;

    /**
     * Return inner object
     * @return mixed
     */
    public function getStoredValue();

    /**
     * Set instance
     * @param $value
     * @return Ghost
     */
    public function storeValue(&$value):Ghost;
}