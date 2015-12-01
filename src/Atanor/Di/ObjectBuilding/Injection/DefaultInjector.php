<?php
declare(strict_types=1);
namespace Atanor\Di\ObjectBuilding\Injection;

use Atanor\Di\Exception\BestInjectionStrategyNotFound;
use Atanor\Di\Exception\NoSuitableInjectionStrategyFoundException;
use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;
use Atanor\Di\ObjectBuilding\Injection\Dependency\PropertyDependency;
use Atanor\Di\ObjectBuilding\Injection\Strategy\AdderStrategy;
use Atanor\Di\ObjectBuilding\Injection\Strategy\InjectionStrategy;

/**
 * Class DefaultInjector
 */
class DefaultInjector implements Injector, BootableInjector
{
    /**
     * Collection of injectionStrategy
     * @var \Traversable|array
     */
    protected $injectionStrategies = [];

    /**
     * @var array
     */
    protected $favoriteInjectionStrategies = [];

    /**
     * @inheritDoc
     */
    public function __construct()
    {
    }

    /**
     * @inheritdoc
     */
    public function boot($dependencies):BootableInjector
    {
        $this->addToInjectionStrategies(new AdderStrategy());
        $strategiesToInject = [];
        foreach ($dependencies as $dependency) {
            if ( ! $dependency instanceof PropertyDependency) continue;
            if ( ! $dependency->getValue() instanceof InjectionStrategy) continue;
            $value = $dependency->getValue();
            if ($value instanceof InjectionStrategy) {
                $this->addToInjectionStrategies($value);
            }
            else $strategiesToInject[] = $dependency;
        }
        $this->inject($this,$strategiesToInject);
        return $this;
    }

    /**
     * Insert a new injection strategy service
     * @param InjectionStrategy $injectionStrategy
     * @param int $priority
     * @return Injector
     */
    public function addToInjectionStrategies(InjectionStrategy &$injectionStrategy):Injector
    {
        $this->injectionStrategies[] = $injectionStrategy;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function inject(&$targetInstance, $dependencyList)
    {
        $targetClass = get_class($targetInstance);
        foreach($dependencyList as $dependency){
            $injectionStrategy = null;
            $needFavoriteStrategyToBeAdded = false;
            if ($this->hasFavoriteInjectionStrategy($targetClass,$dependency)) {
                $injectionStrategy = $this->getFavoriteInjectionStrategy($targetClass,$dependency);
            }
            else {
                $injectionStrategy = $this->selectInjectionStrategy($targetInstance,$dependency);
                $needFavoriteStrategyToBeAdded = true;
            }
            if ( ! $injectionStrategy) {
                throw new NoSuitableInjectionStrategyFoundException();
            }
            $injectionStrategy->inject($targetInstance,$dependency);
            if ($needFavoriteStrategyToBeAdded) {
                $this->addToFavoriteInjectionStrategies($targetClass,$injectionStrategy,$dependency);
            }
        }
        return $targetInstance;
    }

    /**
     * Add strategy to favorite for the given class en dependency
     * @param string $className
     * @param InjectionStrategy $strategy
     * @param Dependency $dependency
     * @return Injector
     */
    public function addToFavoriteInjectionStrategies(string $className,InjectionStrategy &$strategy,Dependency $dependency):Injector
    {
        if ( ! isset($this->favoriteInjectionStrategies[$className])) $this->favoriteInjectionStrategies[$className] = [];
        $tag = $this->getFavoriteStrategyDependencyTag($dependency);
        $this->favoriteInjectionStrategies[$className][$tag] = $strategy;
        return $this;
    }

    /**
     * Returns true if it exists a favorite injection strategy for this class and dependency
     * @param string $className
     * @param Dependency $dependency
     * @return bool
     */
    public function hasFavoriteInjectionStrategy(string $className,Dependency $dependency):bool
    {
        if ( ! isset($this->favoriteInjectionStrategies[$className])) return false;
        $tag = $this->getFavoriteStrategyDependencyTag($dependency);
        return isset($this->favoriteInjectionStrategies[$className[$tag]]);
    }

    /**
     * Returns favorite injection strategy for given class and dependency
     * @param string $className
     * @param Dependency $dependency
     * @return InjectionStrategy
     * @throws BestInjectionStrategyNotFound
     */
    public function getFavoriteInjectionStrategy(string $className,Dependency $dependency):InjectionStrategy
    {
        if ( ! $this->hasFavoriteInjectionStrategy($className,$dependency)) {
            throw new BestInjectionStrategyNotFound();
        }
        $tag = $this->getFavoriteStrategyDependencyTag($dependency);
        return $this->favoriteInjectionStrategies[$className[$tag]];
    }

    /**
     * @param Dependency $dependency
     * @return string
     */
    protected function getFavoriteStrategyDependencyTag(Dependency $dependency)
    {
        if ($dependency instanceof PropertyDependency) {
            $tag = 'property:' . $dependency->getPropertyName();
        }
        else {
            $value = $dependency->getValue();
            if (gettype($value) !== 'object')  $tag = 'type:' . gettype($value);
            else $tag = 'type:'. get_class($value);
        }
        return $tag;
    }

    /**
     * Select best injection strategy
     * @param Dependency $dependency
     * @return InjectionStrategy
     * @throws \Exception
     */
    protected function selectInjectionStrategy(&$instance,Dependency $dependency):InjectionStrategy
    {
        foreach($this->injectionStrategies as $injectionStrategy) {
            /** @var InjectionStrategy $injectionStrategy */
            if ( ! $injectionStrategy->canInject($instance,$dependency)) continue;
            return $injectionStrategy;
        }
        throw new NoSuitableInjectionStrategyFoundException();
    }
}
