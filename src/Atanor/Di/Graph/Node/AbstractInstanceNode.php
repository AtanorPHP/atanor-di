<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Node;

abstract class AbstractInstanceNode implements InstanceNode
{
    /**
     * Insatnce type hint
     * @var string
     */
    protected $typeHint;

    /**
     * @var mixed
     */
    protected $instance;

    /**
     * @inheritDoc
     */
    public function getTypeHint()
    {
        if ($this->isInstantiated()) {
            $instance = $this->getInstance();
            $type = gettype($instance);
            if ($type == 'object') return get_class($instance);
            else return $type;
        }
        return $this->typeHint;
    }

    /**
     * @inheritDoc
     */
    public function isInstantiated():bool
    {
        return ! is_null($this->instance);
    }

    /**
     * @inheritDoc
     */
    public function getInstance()
    {
        if ( ! $this->isInstantiated()) {
            throw new \Exception('Node not instantiated');
        }
        return $this->instance;
    }

    /**
     * @inheritDoc
     */
    public function setInstance(&$instance):InstanceNode
    {
        $this->instance = $instance;
        return $this;
    }

    /**
     * Set type int
     * @param array|\ArrayAccess $config
     */
    public function setTypeHint($config):InstanceNode
    {
        if ( ! isset($config[static::OPTION_TYPE_HINT])) return $this;
        $this->typeHint = $config[static::OPTION_TYPE_HINT];
        return $this;
    }

}