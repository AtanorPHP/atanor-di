<?php
namespace Atanor\Di\Graph\Node\Feature;

use Atanor\Di\Graph\InstanceNode;

interface MutableInstanceNode
{
    /**
     * @param \ArrayAccess $config
     * @return $this
     */
    public function setOptions($config):MutableInstanceNode;
}
