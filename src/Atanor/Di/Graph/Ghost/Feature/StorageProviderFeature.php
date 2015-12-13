<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

use Atanor\Di\Graph\Ghost\AbstractFeature;
use Atanor\Di\Graph\Ghost\Ghost;

class StorageProviderFeature extends AbstractFeature implements StorageProvider
{
    /**
     * @var mixed
     */
    protected $storedValue;

    /**
     * @var bool
     */
    protected $hasStoreValue = false;

    /**
     * @inheritDoc
     */
    public function hasStoredValue():bool
    {
        return $this->hasStoreValue;
    }

    /**
     * @inheritDoc
     */
    public function getStoredValue()
    {
        if ( ! $this->hasStoreValue) {
            //@todo throw exception
        }
        return $this->storedValue;
    }

    /**
     * @inheritDoc
     */
    public function storeValue(&$value):Ghost
    {
        $this->storedValue = $value;
        return $this;
    }

}