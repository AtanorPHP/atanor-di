<?php
declare(strict_types=1);
namespace Atanor\Di\ObjectBuilding\Injection;

class InjectionStrategyManager
{
    /**
     * List of injection strategy
     * @var array
     */
    protected $injectionsStrategies = [];

    /**
     * Registry of best strategies
     * @var array
     */
    protected $bestStrategies = [];

    /**
     * @return array
     */
    public function getStrategies()
    {
        return $this->injectionsStrategies;
    }

    /**
     * Add injecton strategy
     * @param InjectionStrategy $strategy
     * @param int $priority
     * @return InjectionStrategyManager
     */
    public function addInjectionStrategy(InjectionStrategy &$strategy,int $priority = 0):InjectionStrategyManager
    {
        $this->injectionsStrategies[] = [$strategy,$priority];
        return $this;
    }

    /**
     * Set injection strategy has the best one for given class and property
     * @param string            $className
     * @param string            $propertyName
     * @param InjectionStrategy $strategy
     * @return InjectionStrategyManager
     */
    public function setBestStrategy(string $className,string $propertyName,InjectionStrategy &$strategy):InjectionStrategyManager
    {
        if ( ! isset($this->bestStrategies[$className])) $this->bestStrategies[$className] = [];
        $this->bestStrategies[$className][$propertyName] = $strategy;
        return $this;
    }

    /**
     * Returns true if manager has a best injection strategy for given class and property
     * @param string $className
     * @param string $propertyName
     * @return bool
     */
    public function hasBestStrategy(string $className,string $propertyName):bool
    {
        return isset($this->bestStrategies[$className][$propertyName]);
    }

    /**
     * Returns best known injection strategy for the given class and property
     * @param string    $className
     * @param string    $propertyName
     * @return InjectionStrategy
     * @throw \Exception
     */
    public function getBestStrategy(string $className,string $propertyName):InjectionStrategy
    {
        if ( ! $this->hasBestStrategy($className,$propertyName)) {
            throw new \Exception("$className strategy has no best strategy for $propertyName");
        }
        return $this->bestStrategies[$className][$propertyName];
    }
}
