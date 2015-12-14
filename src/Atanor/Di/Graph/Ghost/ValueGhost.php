<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost;

use Atanor\Di\Graph\Ghost\Feature\StorageProviderFeature;

class ValueGhost extends AbstractFeaturedGhost implements Ghost
{
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
        return $this->getFeature(StorageProviderFeature::class)->getStoredValue();
    }

    /**
     * @inheritDoc
     * @return ValueGhost
     */
    public static function build(array $params):Ghost
    {
        $ghost = new self();
        $ghost->addFeature(new StorageProviderFeature($ghost));
        if (isset($params['value'])) {
            $ghost->getFeature(StorageProviderFeature::class)->storeValue($params['value']);
        }
        return $ghost;
    }
}