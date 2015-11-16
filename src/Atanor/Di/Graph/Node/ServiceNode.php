<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Node;

use Atanor\Di\Graph\Node\Feature\MutableInstanceNode;
use Atanor\Di\Graph\Node\Feature\Service;

class ServiceNode extends AbstractInstanceNode implements MutableInstanceNode,Service
{
    /**
     * Service name
     * @var string
     */
    protected $name;

    /**
     * @inheritDoc
     */
    public function setOptions($config):MutableInstanceNode
    {
        $this->setServiceName($config);
        return $this;
    }

    /**
     * Set servie name from config
     * @param array|\ArrayAccess $config
     * @return ServiceNode
     */
    protected function setServiceName($config):ServiceNode
    {
        if ( ! isset($config[static::OPTION_SERVICE_NAME])) return $this;
        $this->name = $config[static::OPTION_SERVICE_NAME];
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getId():string
    {
        return $this->name;
    }
}