<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph;

use Atanor\Di\Graph\Bond\Bond;
use Atanor\Di\Graph\Avatar\Avatar;
use Atanor\Graph\Graph\AbstractGraph;
use Atanor\Di\Graph\Bond\PropertyBond;
use Atanor\Di\Graph\Avatar\ValueAvatar;
use Atanor\Di\ObjectBuilding\Injection\Dependency;
use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;

class DefaultAvatarGraph extends AbstractGraph implements AvatarGraph
{
    /**
     * @inheritDoc
     */
    public function addAvatar(Avatar $avatar):AvatarGraph
    {
        return $this->addNode($avatar);
    }

    /**
     * @inheritDoc
     */
    public function addBond(Bond $bond):AvatarGraph
    {
        return $this->addEdge($bond);
    }

    /**
     * @inheritDoc
     */
    public function getDependencyBonds(Avatar $avatar):array
    {
        $dependencies = [];
        foreach($this->edges as $edge) {
            if ($edge->getTail() !== $avatar) continue;
            $dependencies[] = $edge;
        }
        return $dependencies;
    }

    /**
     * @inheritDoc
     */
    public function hasDependencyBonds(Avatar $avatar):bool
    {
        $dependencyEdge = $this->getDependencyBonds($avatar);
        if (count($dependencyEdge) == 0) return false;
        return true;
    }


    /**
     * @inheritdoc
     */
    public function getDependencyObjects(Avatar $avatar, $instantiationCallback):array
    {
        $dependencyObjects = [];
        foreach($this->getDependencyBonds($avatar) as $edge) {
            $dependencyNode = $edge->getHead();
            $value = call_user_func_array($instantiationCallback,[$dependencyNode]);
            if ($dependencyNode instanceof ValueAvatar) {
                $value = $dependencyNode->getObject();
            }
            if ($edge instanceof PropertyBond) {
                $propertyName = $edge->getPropertyName();
                $dependency = new PropertyDependency($propertyName,$value);
            }
            else {
                $dependency = new Dependency($value);
            }
            $dependencyObjects[] = $dependency;
        }
        return $dependencyObjects;
    }
}