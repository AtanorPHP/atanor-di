<?php
declare(strict_types=1);
namespace Atanor\Di\Graph\Ghost\Feature;

use Atanor\Graph\Node\NodeIdProvider;

interface IdentityProvider extends NodeIdProvider
{
    const PARAM_ID_NAME = 'id';
    /**
     * IdentityProvider name
     * @return string
     */
    public function getId():string;

    /**
     * @param string $id
     * @return IdentityProvider
     */
    public function setId(string $id):IdentityProvider;
}
