<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Avatar;

abstract class AbstractObjectAvatar implements Avatar
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
            throw new \Exception('Avatar not instantiated');
        }
        return $this->object;
    }

    /**
     * @inheritDoc
     */
    public function setObject(&$object):Avatar
    {
        $this->object = $object;
        return $this;
    }

    /**
     * Set type int
     * @param array|\ArrayAccess $config
     */
    public function setObjectType($typeHint):Avatar
    {
        $this->className = $typeHint;
        return $this;
    }

}