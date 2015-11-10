<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Node;

use Atanor\Di\Graph\Node\Feature\MutableInstanceNode;

class InstanceNodeFactory
{
    const OPTION_INSTANCE_NODE_CLASS = 'instanceNodeClass';
    const OPTION_NODE_OPTIONS = 'options';

    public function buildInstanceNode($config)
    {
        //@todo: check config compliance
        $instanceNodeClass = $this->getInstanceNodeClass($config);
        $instanceNode = new $instanceNodeClass();
        if ($instanceNode instanceof MutableInstanceNode) {
            if (isset($config[static::OPTION_NODE_OPTIONS])) {
                $instanceNode->setOptions($config[static::OPTION_NODE_OPTIONS]);
            }
        }
        return $instanceNode;
    }

    protected function getInstanceNodeClass($config):string
    {
        if (!isset($config[static::OPTION_INSTANCE_NODE_CLASS])) {

        }
        return $config[static::OPTION_INSTANCE_NODE_CLASS];
    }
}