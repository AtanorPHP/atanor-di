<?php
declare(strict_types = 1);
namespace Atanor\Di\Container\Registry;

use Atanor\Di\Graph\Ghost\AbstractFeaturedGhost;
use Atanor\Di\Graph\Ghost\Feature\IdentityProvider;
use Atanor\Di\Graph\Ghost\Feature\IdentityProviderFeature;
use Atanor\Di\Graph\Ghost\Feature\StorageProvider;
use Atanor\Di\Graph\Ghost\Feature\StorageProviderFeature;
use Atanor\Di\Graph\Ghost\Ghost;

class RegistryEntryGhost extends AbstractFeaturedGhost implements Ghost,IdentityProvider,StorageProvider
{
    /**
     * @inheritDoc
     */
    public function getId():string
    {
        return $this->getFeature(IdentityProviderFeature::class)->getId();
    }

    /**
     * @inheritDoc
     */
    public function getNodeId():string
    {
        return $this->getFeature(IdentityProviderFeature::class)->getNodeId();
    }

    /**
     * @inheritDoc
     */
    public function hasStoredValue():bool
    {
        return $this->getFeature(StorageProviderFeature::class)->$this->hasStoredValue();
    }

    /**
     * @inheritDoc
     */
    public function getStoredValue()
    {
        return $this->getFeature(StorageProviderFeature::class)->$this->getStoredValue();
    }

    /**
     * @inheritDoc
     */
    public function storeValue(&$value):Ghost
    {
        return $this->getFeature(StorageProviderFeature::class)->$this->storeValue($value);
    }

    /**
     * @inheritDoc
     */
    public function getObjectType():string
    {
        $value = $this->getStoredValue();
        if (gettype($value) == 'object') return get_class($value);
        else return gettype($value);
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id):IdentityProvider
    {
        return $this->getFeature(IdentityProviderFeature::class)->setid($id);
    }

    /**
     * @inheritDoc
     */
    public static function build(array $params):Ghost
    {
        $ghost = new self();
        $ghost->addFeature(StorageProviderFeature::build($ghost,$params))
            ->addFeature(IdentityProviderFeature::build($ghost,$params));
        return $ghost;
    }
}