<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Ghost;

use Atanor\Di\Graph\Ghost\Feature\NamedGhost;
use Atanor\Di\Graph\Ghost\Feature\IdentityProviderFeature;

class StubGhostPrototype extends GhostPrototype implements Ghost,NamedGhost
{
    /**
     * StubGhostPrototype constructor.
     * @param string $id
     */
    public function __construct($id)
    {
        $this->addFeature(new IdentityProviderFeature($this));
        $this->getFeature(IdentityProviderFeature::class)
            ->setId($id);
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
    public function getNodeId():string
    {
        return $this->getFeature(IdentityProviderFeature::class)->getNodeId();
    }


    /**
     * @inheritDoc
     */
    public function getObjectType():string
    {
        return 'stub';
    }
}