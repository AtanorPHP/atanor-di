<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

use Atanor\Di\Graph\Ghost\AbstractFeature;
use Atanor\Di\Graph\Ghost\Feature;
use Atanor\Di\Graph\Ghost\FeatureAware;
use Atanor\Di\Graph\Ghost\Ghost;

class UnicityProviderFeature extends AbstractFeature implements UnicityProvider
{
    /**
     * @inheritDoc
     */
    public function isMaterialized():bool
    {
        return $this->ghost->getFeature(StorageProviderFeature::class)->hasStoredValue();
    }

    /**
     * @inheritDoc
     */
    public function getInstance()
    {
        return $this->ghost->getFeature(StorageProviderFeature::class)->getStoredValue();
    }

    /**
     * @inheritDoc
     */
    public function setInstance($instance):UnicityProvider
    {
        return $this->ghost->getFeature(StorageProviderFeature::class)->storeValue($instance);
    }

    /**
     * @inheritDoc
     */
    public static function build(Ghost $ghost, array $params):Feature
    {
        if ( ! $ghost instanceof FeatureAware) {
            //@todo throw exception
        }
        $feature = new self($ghost);
        if ( ! $ghost->hasFeature(StorageProviderFeature::class)) {
            $ghost->addFeature(StorageProviderFeature::build($ghost,$params));
        }
        return $feature;
    }
}