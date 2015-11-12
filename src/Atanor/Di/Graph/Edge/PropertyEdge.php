<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Edge;

use Atanor\Graph\Edge\DefaultArrow;
use Atanor\Graph\Edge\MutableEdge;

class PropertyEdge extends DefaultArrow implements DependencyEdge,MutableEdge
{
    const OPTION_PROPERTY = 'property';

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
     * @inheritDoc
     */
    public function setOptions($options):MutableEdge
    {
        if (isset($options[static::OPTION_PROPERTY])) {
            $this->propertyName = $options[static::OPTION_PROPERTY];
        }
        return $this;
    }


}