<?php
declare(strict_types = 1);

namespace Atanor\Di\ObjectBuilding\Injection;

class MinimalInjector extends DefaultInjector
{
    /**
     * @inheritDoc
     */
    public function inject(&$targetInstance, $dependencyList):bool
    {
        foreach($dependencyList as $propertyName => $dependencyArray)
        {
            foreach($dependencyArray as $dependency) {
                $setterMethod = 'set' . ucfirst($propertyName);
                if ( ! method_exists($targetInstance,$setterMethod)) {
                    $setterMethod = 'addTo' . ucfirst($propertyName);
                }
                if ( ! method_exists($targetInstance,$setterMethod)) {
                    $class = get_class($targetInstance);
                    throw new \Exception ("Enable to find a way to inject $propertyName in $class");
                }
                $targetInstance->$setterMethod($dependency);
            }
        }
        return true;
    }

}