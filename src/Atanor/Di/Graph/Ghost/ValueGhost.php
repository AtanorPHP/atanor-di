<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost;

use Atanor\Di\Graph\Ghost\Feature\StorageProviderFeature;

class ValueGhost extends DefaultGhost implements Ghost
{
    /**
     * ValueGhost constructor.
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->addFeature(new StorageProviderFeature($this));
        $this->getFeature(StorageProviderFeature::class)->storeValue($value);
    }

    /**
     * @inheritDoc
     */
    public function getObjectType():string
    {
        $value = $this->getValue();
        if (is_object($value)) return get_class($value);
        return gettype($value);
    }

    /**
     * Return value
     * @return mixed
     */
    public function getValue()
    {
        return $this->getFeature(StorageProviderFeature::class)->getStoredValue();;
    }

}