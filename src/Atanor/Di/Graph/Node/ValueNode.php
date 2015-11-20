<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Node;

class ValueNode implements InstanceNode
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * ValueNode constructor.
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function getTypeHint()
    {
        if (is_object($this->value)) return get_class($this->value);
        return gettype($this->value);
    }

    /**
     * @inheritDoc
     */
    public function isInstantiated():bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getInstance()
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function setInstance(&$instance):InstanceNode
    {
        return $this;
    }
}