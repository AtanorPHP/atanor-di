<?php
declare(strict_types = 1);
namespace Atanor\Di\Container\ServiceLocator;

use Atanor\Di\Container\AbstractContainer;
use Atanor\Di\Container\Registry\Registry;
use Atanor\Di\Graph\DiGraph;
use Atanor\Di\ObjectBuilding\Construction\BasicConstructor;
use Atanor\Di\ObjectBuilding\Construction\ConstructorStack;
use Atanor\Di\ObjectBuilding\Construction\LittleConstructor;
use Atanor\Di\ObjectBuilding\Construction\ReflectionConstructor;
use Atanor\Di\ObjectBuilding\Injection\DefaultInjector;
use Atanor\Di\ObjectBuilding\Injection\Strategy\AdderStrategy;
use Atanor\Di\ObjectBuilding\Injection\Strategy\InjectionInterfaceStrategy;
use Atanor\Di\ObjectBuilding\Injection\Strategy\ReflectionStrategy;
use Atanor\Di\ObjectBuilding\Injection\Strategy\SetterStrategy;

class DynamicServiceLocator extends AbstractContainer implements Registry
{
    /**
     * DynamicServiceLocator constructor.
     */
    public function __construct(DiGraph $graph)
    {
        $this->setDiGraph($graph);
        $this->constructor = new ConstructorStack();
        $this->constructor
            ->addToConstructorStack(new BasicConstructor())
            ->addToConstructorStack(new LittleConstructor())
            ->addToConstructorStack(new ReflectionConstructor());
        $this->injector = new DefaultInjector();
        $this->injector
            ->addToInjectionStrategies(new SetterStrategy())
            ->addToInjectionStrategies(new AdderStrategy())
            ->addToInjectionStrategies(new InjectionInterfaceStrategy())
            ->addToInjectionStrategies(new ReflectionStrategy());
    }

    /**
     * @inheritDoc
     */
    public function get(string $name)
    {
        if ( ! $this->has($name)) {
            throw new \Exception("No registered service named $name");
        }
        return $this->getInstance($name);
    }

    /**
     * @inheritDoc
     */
    public function has(string $name):bool
    {
        return $this->diGraph->containsNodeId($name);
    }

    /**
     * @inheritDoc
     */
    public function set(string $name, $className):Registry
    {
        $serviceNode = new ServiceGhost($name,$className);
        $this->diGraph->addGhost($serviceNode);
        return $this;
    }
}