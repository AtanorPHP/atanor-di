<?php
declare(strict_types = 1);
namespace Atanor\Di\Container\Registry;

use Atanor\Di\Graph\Ghost\Feature\IdentityProvider;
use Atanor\Di\Graph\Ghost\Feature\IdentityProviderTrait;
use Atanor\Di\Graph\Ghost\ValueGhost;

class RegistryEntryGhost extends ValueGhost implements IdentityProvider
{
    use IdentityProviderTrait;

    /**
     * RegistryEntryGhost constructor.
     */
    public function __construct(string $id,$value)
    {
        $this->value = $value;
        $this->id = $id;
    }
}