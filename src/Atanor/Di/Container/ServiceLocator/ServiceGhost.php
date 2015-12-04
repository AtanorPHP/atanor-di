<?php
declare(strict_types = 1);

namespace Atanor\Di\Container\ServiceLocator;

use Atanor\Di\Graph\Ghost\Feature\GhostGraphTrait;
use Atanor\Di\Graph\Ghost\Feature\IdentityProvider;
use Atanor\Di\Graph\Ghost\Feature\IdentityProviderTrait;
use Atanor\Di\Graph\Ghost\Feature\TagProviderTrait;
use Atanor\Di\Graph\Ghost\Feature\TagProvider;
use Atanor\Di\Graph\Ghost\AbstractObjectGhost;
use Atanor\Di\Graph\Link\ConstructorLink;
use Atanor\Di\Graph\Link\PropertyLink;

class ServiceGhost extends AbstractObjectGhost implements IdentityProvider,TagProvider
{
    use IdentityProviderTrait;
    use TagProviderTrait;
    use GhostGraphTrait;

    /**
     * @inheritdoc
     */
    public function __construct(string $id,string $className,array $tags = [])
    {
        $this->id = $id;
        $this->setObjectType($className);
        if (count($tags)>0) $this->addTags($tags);
    }

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
}