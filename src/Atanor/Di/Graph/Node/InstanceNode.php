<?php
namespace Atanor\Di\Graph\Node;

interface InstanceNode
{
    /**
     * Returns instance node type hint or className
     * @return string
     */
    public function getTypeHint();

    /**
     * Returns true if node has been instanciated
     * @return bool
     */
    public function isInstantiated():bool;

    /**
     * Returns instance
     * @return mixed
     */
    public function getInstance();

    /**
     * Set instance
     * @param $instance
     * @return InstanceNode
     */
    public function setInstance(&$instance):InstanceNode;
}
