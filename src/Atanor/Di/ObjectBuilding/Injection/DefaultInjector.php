<?php
declare(strict_types=1);
namespace Atanor\Di\ObjectBuilding\Injection;

class DefaultInjector implements Injector
{
    /**
     * Injection strategies manager
     * @var InjectionStrategyManager
     */
    protected $injectionStrategyManager;

    /**
     * @inheritdoc
     */
    public function inject(&$targetInstance, $dependencyList):bool
    {
        $injectedProperties = [];
        $targetClass = get_class($targetInstance);
        foreach($dependencyList as $property => $dependency){
            if (in_array($property,$injectedProperties)) continue;
            if ($this->injectionStrategyManager->hasBestStrategy($targetClass,$property)) {
                $injectionStrategy = $this->injectionStrategyManager->getBestStrategy($targetClass,$property);
            }
            else {
                $injectionStrategy = $this->selectInjectionStrategy($targetInstance,$dependency,$property);
            }
            if ( ! $injectionStrategy) {
                //@todo throw warning : enable to find a suitable injection strategy for current dependency
                continue;
            }
            $propertyName = $injectionStrategy->inject($targetInstance,$dependency,$property);
            $injectedProperties[] = $propertyName;
            $this->injectionStrategyManager->setBestStrategy($targetClass,$propertyName,$injectionStrategy);
            return true;
        }
        return false;
    }

    /**
     * Set injection strategies manager
     * @param InjectionStrategyManager $injectionStrategyManager
     * @return DefaultInjector
     */
    public function setInjectionStrategyManager(InjectionStrategyManager $injectionStrategyManager):DefaultInjector
    {
        $this->injectionStrategyManager = $injectionStrategyManager;
        return $this;
    }

    /**
     * Select best injection strategy
     * @param mixed $targetInstance
     * @param mixed $dependency
     * @param string $property
     * @return InjectionStrategy
     * @throws \Exception
     */
    protected function selectInjectionStrategy($targetInstance,$dependency,string $property = null):InjectionStrategy
    {
        $strategyQueue = new \SplPriorityQueue();
        foreach($this->injectionStrategyManager->getStrategies() as $injectionStrategyInfo) {
            $strategyQueue->insert($injectionStrategyInfo[0],$injectionStrategyInfo[1]);
        }
        foreach($strategyQueue as $injectionStrategy) {
            if ( ! $injectionStrategy->canInject($targetInstance,$dependency,$property)) continue;
            return $injectionStrategy;
        }
        throw new \Exception('Enable to find a suitable injection strategy for');
    }
}
