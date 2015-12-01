<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Avatar;

class ValueAvatar implements Avatar
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * ValueAvatar constructor.
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function getObjectType():string
    {
        if (is_object($this->value)) return get_class($this->value);
        return gettype($this->value);
    }

    /**
     * @inheritDoc
     */
    public function isMaterialized():bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getObject()
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function setObject(&$object):Avatar
    {
        return $this;
    }
}