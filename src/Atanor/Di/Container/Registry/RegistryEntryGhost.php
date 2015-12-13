<?php
declare(strict_types = 1);
namespace Atanor\Di\Container\Registry;

use Atanor\Di\Graph\Ghost\Feature\IdentityProvider;
use Atanor\Di\Graph\Ghost\Feature\IdentityProviderFeature;
use Atanor\Di\Graph\Ghost\ValueGhost;

class RegistryEntryGhost extends ValueGhost implements IdentityProvider
{
    use IdentityProviderFeature;

    /**
     * RegistryEntryGhost constructor.
     */
    public function __construct(string $id,$value)
    {
        $this->value = $value;
        $this->id = $id;
    }
}