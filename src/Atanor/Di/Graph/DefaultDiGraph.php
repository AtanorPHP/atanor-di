<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph;

use Atanor\Di\Graph\Ghost\Feature\DiGraphAware;
use Atanor\Di\Graph\Link\ConstructorLink;
use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Di\Graph\Link\PropertyLink;
use Atanor\Graph\Graph\AbstractDirectedGraph;
use Atanor\Graph\Graph\Graph;

class DefaultDiGraph extends AbstractDirectedGraph implements DiGraph
{
    /**
     * @inheritdoc
     */
    public function getDependencies(Ghost $ghost, $materializationCallback):array
    {
        $dependencyObjects = [];
        foreach($this->getChildrenEdges($ghost) as $link) {
            $value = $link->getHead();
            if ($value instanceof Ghost) {
                $value = call_user_func($materializationCallback,$value);
            }
            $link->setValue($value);
            $dependencyObjects[] = $link;
        }
        return $dependencyObjects;
    }

    /**
     * @inheritDoc
     */
    public function getConstructorDependencies(Ghost $ghost, $invocationCallback):array
    {
        $constructorParams = [];
        foreach($this->getChildrenEdges($ghost) as $link) {
            if ( ! $link instanceof ConstructorLink) continue;
            $param = $link->getHead();
            if ($param instanceof Ghost) {
                $param = call_user_func_array($invocationCallback,[$param]);
            }
            $constructorParams[$link->getPosition()] = $param;
        }
        return $constructorParams;
    }

    /**
     * @inheritDoc
     */
    public function getInjectableDependencies(Ghost $ghost, $invocationCallback):array
    {
        $injectableDependencies = [];
        foreach($this->getChildrenEdges($ghost) as $link) {
            if ($link instanceof ConstructorLink) continue;
            $value = $link->getHead();
            if ($value instanceof Ghost) {
                $value = call_user_func($invocationCallback,$value);
            }
            $link->setValue($value);
            $injectableDependencies[] = $link;
        }
        return $injectableDependencies;
    }

    /**
     * @inheritDoc
     */
    public function hasConstructorDependencies(Ghost $ghost):bool
    {
        foreach($this->getChildrenEdges($ghost) as $link) {
            if ($link instanceof ConstructorLink) return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function hasInjectableDependencies(Ghost $ghost):bool
    {
        foreach($this->getChildrenEdges($ghost) as $link) {
            if ( ! $link instanceof ConstructorLink) return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function addPropertyDependency(Ghost $ghost, $value, string $property):DiGraph
    {
        $link = new PropertyLink($ghost,$value);
        $link->setPropertyName($property);
        $this->addEdge($link,true);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addConstructorDependency(Ghost $ghost, $value, int $position):DiGraph
    {
        $link = new ConstructorLink($ghost,$value);
        $link->setPosition($position);
        $this->addEdge($link,true);
        return $this;
    }

}