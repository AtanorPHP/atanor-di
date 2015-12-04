<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Ghost;

use Atanor\Di\Graph\Ghost\Feature\IdentityProvider;
use Atanor\Di\Graph\Ghost\Feature\IdentityProviderTrait;

class StubGhost implements Ghost,IdentityProvider
{
    use IdentityProviderTrait;

    /**
     * StubGhost constructor.
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function getObjectType():string
    {
        return 'stub';
    }

    /**
     * @inheritDoc
     */
    public function isMaterialized():bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getObject()
    {
        throw new \Exception('You cannot instantiate a stub instance node');
    }

    /**
     * @inheritDoc
     */
    public function setObject(&$object):Ghost
    {
        throw new \Exception('You cannot instantiate a stub instance node');
    }
}