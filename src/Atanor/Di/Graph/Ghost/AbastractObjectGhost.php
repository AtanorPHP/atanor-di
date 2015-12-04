<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Ghost;

use Atanor\Di\Graph\DiGraph;
use Atanor\Di\Graph\Link\Link;
use Atanor\Graph\Graph\Graph;
use Atanor\Graph\RootedGraph;

abstract class AbstractObjectGhost implements Ghost
{
    /**
     * Object type hint
     * @var string
     */
    protected $className;

    /**
     * @var mixed
     */
    protected $object;

    /**
     * @inheritDoc
     */
    public function getObjectType():string
    {
        if ($this->isMaterialized()) {
            return get_class($this->object);
        }
        return $this->className;
    }

    /**
     * @inheritDoc
     */
    public function isMaterialized():bool
    {
        return ! is_null($this->object);
    }

    /**
     * @inheritDoc
     */
    public function getObject()
    {
        if ( ! $this->isMaterialized()) {
            throw new \Exception('Ghost not instantiated');
        }
        return $this->object;
    }

    /**
     * @inheritDoc
     */
    public function setObject(&$object):Ghost
    {
        $this->object = $object;
        return $this;
    }

    /**
     * Set type int
     * @param array|\ArrayAccess $config
     */
    public function setObjectType($typeHint):Ghost
    {
        $this->className = $typeHint;
        return $this;
    }



}