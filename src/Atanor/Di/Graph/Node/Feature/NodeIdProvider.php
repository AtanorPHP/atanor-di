<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Node\Feature;

interface NodeIdProvider
{
    /**
     * Returns a node id
     * @return string
     */
    public function getId():string;
}
