<?php
declare(strict_types = 1);
namespace Atanor\Di\Configuration\Graph;

use Atanor\Di\Graph\Edge\PropertyEdge;

class PropertyEdgeFactoryConfiguration extends DependencyEdgeFactoryConfiguration
{
    const OPTION_PROPERTY = 'property';

    /**
     * PropertyEdgeFactoryConfiguration constructor.
     */
    public function __construct(string $property = null)
    {
        $this->data[static::OPTION_EDGE_CLASS] = PropertyEdge::class;
        if ($property) $this->setProperty($property);
    }

    /**
     * Set property name
     * @param string $propertyName
     * @return PropertyEdgeFactoryConfiguration
     */
    public function setProperty(string $propertyName):PropertyEdgeFactoryConfiguration
    {
        $this->data[static::OPTION_PROPERTY] = $propertyName;
        return $this;
    }
}