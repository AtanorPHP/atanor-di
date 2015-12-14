<?php
declare(strict_types = 1);

namespace Atanor\Di\Container\ServiceLocator;

use Atanor\Di\Graph\Ghost\AbstractFeaturedGhost;
use Atanor\Di\Graph\Ghost\Feature\GhostGraphFeature;
use Atanor\Di\Graph\Ghost\Feature\IdentityProvider;
use Atanor\Di\Graph\Ghost\Feature\IdentityProviderFeature;
use Atanor\Di\Graph\Ghost\Feature\UnicityProvider;
use Atanor\Di\Graph\Ghost\Feature\UnicityProviderFeature;
use Atanor\Di\Graph\Link\ConstructorLink;
use Atanor\Di\Graph\Link\PropertyLink;
use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Graph\Node\NodeIdProvider;

class ServiceGhost extends AbstractFeaturedGhost implements Ghost,NodeIdProvider,IdentityProvider,UnicityProvider
{
    const PARAM_OBJECT_TYPE_NAME = 'objectType';

    /**
     * @var string
     */
    protected $objectType;

    /**
     * Add property dependnecy
     * @param string $property
     * @param string $dependencyId
     * @return ServiceGhost
     */
    public function addServicePropertyLink(string $property,string $dependencyId):ServiceGhost
    {
        if ( ! $this->containsNodeId($dependencyId)) {
            //@todo trhow exception
        }
        $link = new PropertyLink($this,$this->getNode($dependencyId));
        $link->setProperty($property);
        return $this;
    }

    /**
     * Add constructor dependency
     * @param int $position
     * @param string $dependencyId
     * @return ServiceGhost
     */
    public function addConstructorDependency(int $position, string $dependencyId):ServiceGhost
    {
        if ( ! $this->containsNodeId($dependencyId)) {
            //@todo trhow exception
        }
        $link = new ConstructorLink($this,$this->getNode($dependencyId));
        $link->setPosition($position);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getObjectType():string
    {
        return $this->objectType;
    }

    /**
     * @param string $objectType
     */
    public function setObjectType(string $objectType):ServiceGhost
    {
        $this->objectType = $objectType;
        return $this;
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
    public function getId():string
    {
        return $this->getFeature(IdentityProviderFeature::class)->getId();
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id):IdentityProvider
    {
        return $this->getFeature(IdentityProviderFeature::class)->setId();
    }

    /**
     * @inheritDoc
     */
    public function isMaterialized():bool
    {
        return $this->getFeature(UnicityProviderFeature::class)->isMaterialized();
    }

    /**
     * @inheritDoc
     */
    public function getInstance()
    {
        return $this->getFeature(UnicityProviderFeature::class)->getInstance();
    }

    /**
     * @inheritDoc
     */
    public function setInstance($instance):UnicityProvider
    {
        return $this->getFeature(UnicityProviderFeature::class)->setInstance($instance);
    }

    /**
     * @inheritDoc
     */
    public static function build(array $params):Ghost
    {
        $ghost = new self();
        $ghost->addFeature(IdentityProviderFeature::build($ghost,$params))
            ->addFeature(GhostGraphFeature::build($ghost,$params))
            ->addFeature(UnicityProviderFeature::build($ghost,$params));
        if (isset($params[self::PARAM_OBJECT_TYPE_NAME])) {
            $ghost->setObjectType($params[self::PARAM_OBJECT_TYPE_NAME]);
        }
        return $ghost;
    }
}