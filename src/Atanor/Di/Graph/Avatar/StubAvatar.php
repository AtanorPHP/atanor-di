<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Avatar;

use Atanor\Di\Graph\Avatar\Feature\IdentityProvider;
use Atanor\Di\Graph\Avatar\Feature\IdentityProviderTrait;

class StubAvatar implements Avatar,IdentityProvider
{
    use IdentityProviderTrait;

    /**
     * StubAvatar constructor.
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
    public function setObject(&$object):Avatar
    {
        throw new \Exception('You cannot instantiate a stub instance node');
    }
}