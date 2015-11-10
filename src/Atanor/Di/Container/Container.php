<?php
namespace Atanor\Di\Container;

use Atanor\Di\Graph\Node\InstanceNode;

interface Container
{
    /**
     * @param InstanceNode $node
     * @return mixed
     */
    public function build(InstanceNode $node);
}
