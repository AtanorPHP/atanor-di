<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Bond;

use Atanor\Di\Graph\Avatar\Avatar;
use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;
use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;
use Atanor\Graph\Edge\DefaultArrow;
use Atanor\Graph\Edge\MutableEdge;

class PropertyBond extends DefaultBond implements Bond,MutableEdge
{
    /**
     * @var string
     */
    protected $propertyName;

    /**
     * PropertyBond constructor.
     * @param Avatar $node1
     * @param Avatar $node2
     * @param string $propertyName
     */
    public function __construct(Avatar $node1, Avatar $node2, string $propertyName)
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