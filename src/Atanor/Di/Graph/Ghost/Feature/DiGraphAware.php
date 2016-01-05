<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Graph\Node\GraphAware;

interface DiGraphAware extends GraphAware
{
    const CONFIG_PROPERTIES = 'properties';
    const CONFIG_CONSTRUCTOR_PARAMS = 'constructorParams';

    /**
     * @return bool
     */
    public function hasInjectableDependencies():bool;

    /**
     * @return bool
     */
    public function hasConstructorDependencies():bool;

    /**
     * @param $invokationCallback
     * @return mixed
     */
    public function getInjectableDependencies($invocationCallback):array;

    /**
     * @param $invocationCallback
     * @return mixed
     */
    public function getConstructorDependencies($invocationCallback):array;

    /**
     * @param string $property
     * @param mixed $value
     * @return DiGraphAware
     */
    public function addProperty(string $property,$value):DiGraphAware;

    /**
     * @param string $property
     * @param string $objectType
     * @param array $params
     * @return mixed
     */
    public function addPropertyGhost(string $property,string $objectType,array $params = []):Ghost;

    /**
     * @param int $position
     * @param $value
     * @return DiGraphAware
     */
    public function addConstructorParameter(int $position,$value):DiGraphAware;

}