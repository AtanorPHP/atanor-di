<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph;

use Atanor\Di\Graph\Edge\ConstructorParamEdge;
use Atanor\Di\Graph\Edge\DefaultDependencyEdge;
use Atanor\Di\Graph\Edge\PropertyEdge;
use Atanor\Di\Graph\Node\InstanceNode;
use Atanor\Di\Graph\Node\InstanceNodeFactory;
use Atanor\Di\Graph\Node\StubInstanceNode;

class DependencyGraphFactory
{
    const OPTION_GRAPH_CLASS = 'graphClass';
    const OPTION_NODES = 'nodes';
    const OPTION_NODES_DEPENDENCIES = 'dependencies';
    const OPTION_NODES_CONSTRUCTOR_PARAMS = 'constructorParams';

    /**
     * @var InstanceNodeFactory
     */
    protected $instanceNodeFactory;

    /**
     * @param InstanceNodeFactory $instanceNodeFactory
     */
    public function setInstanceNodeFactory(InstanceNodeFactory $instanceNodeFactory):DependencyGraphFactory
    {
        $this->instanceNodeFactory = $instanceNodeFactory;
        return $this;
    }

    /**
     * Buld dependency graph from configuration array
     * @param array|\ArrayAccess$config
     * @return DependencyGraph
     */
    public function buildDependencyGraph($config):DependencyGraph
    {
        //@todo: check config compliance
        $graphClass = $this->getGraphClass($config);
        $dependencyGraph = new $graphClass();
        foreach($config[static::OPTION_NODES] as $nodeConfig) {
            $instanceNode = $this->getInstanceNode($nodeConfig);
            $this->setDependencies($instanceNode,$nodeConfig,$dependencyGraph)
                 ->setConstructorParams($instanceNode,$nodeConfig,$dependencyGraph);
        }
        return $dependencyGraph;
    }

    /**
     * Returns dependency graph class
     * @param $config
     * @return string
     */
    protected function getGraphClass($config):string
    {
        if (isset($config[static::OPTION_GRAPH_CLASS])) return $config[static::OPTION_GRAPH_CLASS];
    }

    /**
     * Returns instance node from configuration.
     * @param $nodeConfig
     * @return InstanceNode
     */
    protected function getInstanceNode($nodeConfig):InstanceNode
    {
        return $this->instanceNodeFactory->buildInstanceNode($nodeConfig);
    }

    /**
     * Set node dependnecies (property dependencies)
     * @param InstanceNode $node
     * @param $nodeConfig
     * @param DependencyGraph $graph
     * @return DependencyGraphFactory
     */
    protected function setDependencies(InstanceNode $node, $nodeConfig, DependencyGraph $graph):DependencyGraphFactory
    {
        if ( ! isset($nodeConfig[static::OPTION_NODES_DEPENDENCIES])) return $this;
        foreach($nodeConfig[static::OPTION_NODES_DEPENDENCIES] as $propertyName => $dependencyNodeConfig) {
            $dependencyNode = $this->getDependencyNodeFromNodeConfig($dependencyNodeConfig,$graph);
            if ( ! is_numeric($propertyName)) {
                $edge = new DefaultDependencyEdge($node,$dependencyNode);
            }
            else {
                $edge = new PropertyEdge($node,$dependencyNode);
                $edge->setPropertyName($propertyName);
            }
            $graph->addDependency($edge);
        }
        return $this;
    }
    /**
     * Set nconstructor paremeters
     * @param InstanceNode $node
     * @param $nodeConfig
     * @param DependencyGraph $graph
     * @return DependencyGraphFactory
     */
    protected function setConstructorParams(InstanceNode $node, $nodeConfig, DependencyGraph $graph):DependencyGraphFactory
    {
        if ( ! isset($nodeConfig[static::OPTION_NODES_CONSTRUCTOR_PARAMS])) return $this;
        foreach($nodeConfig[static::OPTION_NODES_CONSTRUCTOR_PARAMS] as $position => $dependencyNodeConfig) {
            $dependencyNode = $this->getDependencyNodeFromNodeConfig($dependencyNodeConfig,$graph);
            $edge = new ConstructorParamEdge($node,$dependencyNode);
            $edge->setPosition($position);
            $graph->addDependency($edge);
        }
        return $this;
    }

    /**
     * Create dependency node form config or retrieve it from graph
     * if node config is a string, it will look fo the node having this string as Id or will create a stub node
     * waiting to have the node configuration later.
     * @param $dependencyNodeConfig
     * @param DependencyGraph $graph
     * @return InstanceNode
     */
    protected function getDependencyNodeFromNodeConfig($dependencyNodeConfig,DependencyGraph $graph):InstanceNode
    {
        $dependencyNode = null;
        if (is_string($dependencyNodeConfig)) {
            if ($graph->containsNodeId($dependencyNodeConfig)) {
                return $graph->getNode($dependencyNodeConfig);
            }
            else {
                $dependencyNode = new StubInstanceNode($dependencyNodeConfig);
                $graph->addInstanceNode($dependencyNode);
                return $dependencyNode;
            }
        }
        $dependencyNode = $this->getInstanceNode($dependencyNodeConfig);
        $graph->addInstanceNode($dependencyNode);
        return $dependencyNode;
    }
}