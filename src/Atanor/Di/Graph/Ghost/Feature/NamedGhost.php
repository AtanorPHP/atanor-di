<?php
declare(strict_types=1);
namespace Atanor\Di\Graph\Ghost\Feature;

use Atanor\Graph\Node\NodeIdProvider;

interface NamedGhost extends NodeIdProvider
{
    /**
     * NamedGhost name
     * @return string
     */
    public function getId():string;

    /**
     * @param string $id
     * @return NamedGhost
     */
    public function setId(string $id):NamedGhost;
}
