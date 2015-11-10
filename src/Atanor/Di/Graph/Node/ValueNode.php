<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Node;

use Atanor\Di\Graph\InstanceNode;
use Atanor\Di\Graph\Node\Feature\MutableInstanceNode;

class ValueNode implements InstanceNode,MutableInstanceNode
{
    const OPTION_VALUE = 'value';

    /**
     * @var mixed
     */
    protected $value;

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

    /**
     * @inheritDoc
     */
    public function setOptions($config):MutableInstanceNode
    {
        $this->value = $config[static::OPTION_VALUE];
    }
}