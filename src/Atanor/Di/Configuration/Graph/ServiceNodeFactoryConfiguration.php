<?php
declare(strict_types = 1);
namespace Atanor\Di\Configuration\Graph;

use Atanor\Di\Graph\Node\ServiceNode;

class ServiceNodeFactoryConfiguration extends InstanceNodeFactoryConfiguration
{
    const OPTION_SERVICE_NAME = 'serviceName';

    /**
     * ServiceNodeFactoryConfiguration constructor.
     */
    public function __construct(string $className = null, string $serviceName = null)
    {
        $this->data[static::OPTION_NODE_CLASS] = ServiceNode::class;
        if ($className) $this->setTypeHint($className);
        if ($serviceName) $this->setServiceName($serviceName);
    }

    /**
     * Set Service nmae
     * @param string $serviceName
     * @return ServiceNodeFactoryConfiguration
     */
    public function setServiceName(string $serviceName):ServiceNodeFactoryConfiguration
    {
        $this->data[static::OPTION_NODE_OPTIONS][static::OPTION_SERVICE_NAME] = $serviceName;
        return $this;
    }
}