<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Link;

use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;
use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;
use Atanor\Graph\Edge\DefaultArrow;
use Atanor\Graph\Edge\MutableEdge;

class PropertyLink extends DefaultLink implements Link,MutableEdge
{
    const PARAM_PROPERTY_NAME = 'property';

    /**
     * @var string
     */
    protected $property;

    /**
     * Retunrs propertyName
     * @return string
     */
    public function getProperty():string
    {
        return $this->property;
    }

    /**
     * Set property name
     * @param string $property
     * @return PropertyLink
     */
    public function setProperty(string $property):PropertyLink
    {
        if ( ! empty($this->property)) return $this;
        $this->property = $property;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(Ghost $tail, Ghost $head, array $params = array()):Link
    {
        $link = new self($tail,$head);
        if (isset($params[self::PARAM_PROPERTY_NAME])) {
            $link->setProperty($params[self::PARAM_PROPERTY_NAME]);
        }
        return $link;
    }
}