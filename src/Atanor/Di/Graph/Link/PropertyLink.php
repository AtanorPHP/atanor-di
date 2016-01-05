<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Link;

use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;

class PropertyLink extends DefaultLink implements Link,PropertyDependency
{
    /**
     * @var string
     */
    protected $property;

    /**
     * @inheritDoc
     */
    public function getPropertyName():string
    {
        return $this->property;
    }

    /**
     * @inheritDoc
     */
    public function setPropertyName(string $name):PropertyDependency
    {
        $this->property = $name;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public static function build(array $params):Link
    {
        $link = parent::build($params);
        $link->setPropertyName($params['property']);
        return $link;
    }


}