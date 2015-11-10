<?php
declare(strict_types=1);
namespace Atanor\Di\ObjectBuilding\Construction;

class ConstructorStack implements Constructor
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
        $queue = new \SplPriorityQueue();
        foreach($this->constructorStack as $item) {
            $queue->insert($item[1],$item[0]);
        }
        foreach($queue as $constructor) {
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
    public function addConstructor(Constructor &$constructor,int $priority = 0):ConstructorStack
    {
        $this->constructorStack[spl_object_hash($constructor)] = [$priority,$constructor];
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
}
