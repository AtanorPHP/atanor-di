<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Di\Graph\Ghost\Feature\DiGraphAware;
use Atanor\Di\Graph\Ghost\Feature\SingleInstance;
use Atanor\Di\Graph\Ghost\Feature\StoredGhost;
use Atanor\Di\ObjectBuilding\Construction\Constructor;
use Atanor\Di\ObjectBuilding\Injection\Injector;
use Atanor\Di\Graph\Ghost\Ghost;

abstract class AbstractWizard implements Wizard
{
    /**
     * Constructor
     * @var Constructor
     */
    protected $constructor;

    /**
     * Injector
     * @var Injector
     */
    protected $injector;

    /**
     * @inheritDoc
     */
    public function invoke(Ghost $ghost)
    {
        if ($ghost instanceof SingleInstance) {
            if ($ghost->hasStoredValue()) return $ghost->getStoredValue();
        }
        if ($ghost instanceof StoredGhost) {
            if ($ghost->hasStoredValue()) return clone $ghost->getStoredValue();
        }
        $className = $ghost->getObjectType();
        if ($ghost instanceof DiGraphAware) {
            if ($ghost->hasConstructorDependencies()) {
                $constructorParams = $ghost->getConstructorDependencies([$this, 'invoke']);
                $instance = $this->getConstructor()->construct($className, $constructorParams);
            }
            else $instance = new $className();
            if ($ghost->hasInjectableDependencies()) {
                $dependencies = $ghost->getInjectableDependencies([$this, 'invoke']);
                $this->getInjector()->inject($instance, $dependencies);
            }
        }
        else {
            $instance = new $className();
        }
        if ($ghost instanceof StoredGhost) {
            $ghost->storeValue($instance);
        }
        return $instance;
    }

    /**
     * @inheritDoc
     */
    public function setConstructor(Constructor $constructor):Wizard
    {
        $this->constructor = $constructor;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setInjector(Injector $injector):Wizard
    {
        $this->injector = $injector;
        return $this;
    }
}