<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

use Atanor\Di\Graph\Ghost\AbstractFeature;
use Atanor\Di\Graph\Ghost\FeatureAware;
use Atanor\Di\Graph\Ghost\Ghost;

class UnicityProviderFeature extends AbstractFeature implements UnicityProvider
{
    /**
     * UnicityProviderFeature constructor.
     */
    public function __construct(Ghost $ghost)
    {
        if ( ! $ghost instanceof FeatureAware) {
            //@todo throw exception
        }
        $this->ghost = $ghost;
        if ( ! $ghost->hasFeature(StorageProviderFeature::class)) {
            $this->ghost->addFeature(new StorageProviderFeature($ghost));
        }
    }

    /**
     * @inheritDoc
     */
    public function hasStoredValue():bool
    {
        return $this->ghost->getFeature(StorageProviderFeature::class)->hasStoredValue();
    }

    /**
     * @inheritDoc
     */
    public function getStoredValue()
    {
        return $this->ghost->getFeature(StorageProviderFeature::class)->getStoredValue();
    }

    /**
     * @inheritDoc
     */
    public function storeValue(&$value):Ghost
    {
        return $this->ghost->getFeature(StorageProviderFeature::class)->storeValue($value);
    }

    /**
     * @inheritDoc
     */
    public function isMaterialized():bool
    {
        return $this->hasStoredValue();
    }

    /**
     * @inheritDoc
     */
    public function getInsatnce()
    {
        return $this->getStoredValue();
    }
}