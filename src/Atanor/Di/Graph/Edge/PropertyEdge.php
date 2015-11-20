<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Edge;

use Atanor\Di\Graph\Node\InstanceNode;
use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;
use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;
use Atanor\Graph\Edge\DefaultArrow;
use Atanor\Graph\Edge\MutableEdge;

class PropertyEdge extends DefaultArrow implements DependencyEdge,MutableEdge
{
    /**
     * @var string
     */
    protected $propertyName;

    /**
     * PropertyEdge constructor.
     * @param InstanceNode $node1
     * @param InstanceNode $node2
     * @param string $propertyName
     */
    public function __construct(InstanceNode $node1,InstanceNode $node2, string $propertyName)
    {
        $this->setEnds($node1,$node2);
        $this->propertyName = $propertyName;
    }

    /**
     * Retunrs propertyName
     * @return string
     */
    public function getPropertyName():string
    {
        return $this->propertyName;
    }
}