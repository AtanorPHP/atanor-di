<?php
declare(strict_types=1);
namespace Atanor\Di\ObjectBuilding\Construction;

use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;

class ConstructorStack implements Constructor, BootableConstructor
{
    /**
     * Constructors stack
     * @var \Traversable
     */
    protected $constructorStack = [];

    /**
     * @var array|\ArrayAccess
     */
    protected $bestConstructor = [];

    /**
     * @inheritdoc
     */
    public function construct(string $className, $options = null)
    {
        if ($this->hasBestConstructor($className)) {
            $constructor = $this->getBestConstructor($className);
            if ($constructor->canConstruct($className,$options)) {
                return $constructor->construct($className,$options);
            }
        }
        foreach($this->constructorStack as $constructor) {
            if ( ! $constructor->canConstruct($className,$options)) continue;
            $this->setBestConstructor($className,$constructor);
            return $constructor->construct($className,$options);
        }
    }

    /**
     * Add constructor to the queue
     * @param Constructor $constructor
     * @param int         $priority
     * @return ConstructorStack
     */
    public function addToConstructorStack(Constructor &$constructor):ConstructorStack
    {
        $this->constructorStack[] = $constructor;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function canConstruct(string $className, $options = null):bool
    {
        return true;
    }

    /**
     * Add a best constructor for the class
     * @param string        $className
     * @param Constructor   $constructor
     * @return ConstructorStack
     */
    protected function setBestConstructor(string $className,Constructor &$constructor):ConstructorStack
    {
        $this->bestConstructor[$className] = $constructor;
        return $this;
    }

    /**
     * Returns true is there is a "best" constructor for the class
     * @param string $className
     * @return bool
     */
    protected function hasBestConstructor(string $className):bool
    {
        return array_key_exists($className,$this->bestConstructor);
    }

    /**
     * @param string $className
     * @return Constructor|null
     */
    protected function getBestConstructor(string $className):Constructor
    {
        if ( ! $this->hasBestConstructor($className)) return null;
        return $this->bestConstructor[$className];
    }

    /**
     * @inheritDoc
     */
    public function boot($dependencies):BootableConstructor
    {
        foreach ($dependencies as $dependency) {
            if ( ! $dependency instanceof PropertyDependency) continue;
            if ( ! $dependency->getValue() instanceof Constructor) continue;
            $this->addToConstructorStack($dependency->getValue());
        }
        return $this;
    }
}
