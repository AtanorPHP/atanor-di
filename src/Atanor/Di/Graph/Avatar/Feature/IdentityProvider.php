<?php
declare(strict_types=1);
namespace Atanor\Di\Graph\Avatar\Feature;

use Atanor\Graph\Node\NodeIdProvider;

interface IdentityProvider extends NodeIdProvider
{
    /**
     * IdentityProvider name
     * @return string
     */
    public function getId():string;
}
