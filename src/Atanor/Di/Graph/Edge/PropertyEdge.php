<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Edge;

use Atanor\Graph\Edge\DefaultArrow;

class PropertyEdge extends DefaultArrow implements DependencyEdge
{
    /**
     * @var string
     */
    protected $propertyName;

    /**
     * Retunrs propertyName
     * @return string
     */
    public function getPropertyName():string
    {
        return $this->propertyName;
    }

    /**
     * Set property name
     * @param string $propertyName
     */
    public function setPropertyName(string $propertyName):PropertyEdge
    {
        $this->propertyName = $propertyName;
    }
}