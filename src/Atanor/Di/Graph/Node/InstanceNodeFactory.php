<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Node;

use Atanor\Di\Graph\Node\Feature\MutableInstanceNode;
use Atanor\Di\Configuration\Graph\InstanceNodeFactoryConfiguration as nodeConfig;

class InstanceNodeFactory
{
    /**
     * Build instance node from configuration array
     * @param array|\ArrayAccess $config
     * @return InstanceNode
     */
    public function buildInstanceNode($config):InstanceNode
    {
        //@todo: check config compliance
        $instanceNodeClass = $this->getInstanceNodeClass($config);
        $instanceNode = new $instanceNodeClass();
        if ($instanceNode instanceof MutableInstanceNode) {
            if (isset($config[nodeConfig::OPTION_NODE_OPTIONS])) {
                $typeHint = $config[nodeConfig::OPTION_NODE_OPTIONS][nodeConfig::OPTION_INSTANCE_TYPE_HINT];
                $instanceNode->setTypeHint($typeHint);
                $instanceNode->setOptions($config[nodeConfig::OPTION_NODE_OPTIONS]);
            }
        }
        return $instanceNode;
    }

    /**
     * Returns node class
     * @param array|\ArrayAccess$config
     * @return string
     */
    protected function getInstanceNodeClass($config):string
    {
        return $config[nodeConfig::OPTION_NODE_CLASS];
    }
}