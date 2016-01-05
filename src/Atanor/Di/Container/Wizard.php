<?php
declare(strict_types=1);
namespace Atanor\Di\Container;

use Atanor\Di\Graph\DiGraph;
use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Di\ObjectBuilding\Construction\Constructor;
use Atanor\Di\ObjectBuilding\Injection\Injector;

interface Wizard
{
    /**
     * @param Ghost $ghost
     * @return mixed
     */
    public function invoke(Ghost $ghost);

    /**
     * Set constructor
     * @param Constructor $constructor
     * @return Wizard
     */
    public function setConstructor(Constructor $constructor):Wizard;

    /**
     * Set injector
     * @param Injector $injector
     * @return Wizard
     */
    public function setInjector(Injector $injector):Wizard;

    /**
     * @return Injector
     */
    public function getInjector():Injector;

    /**
     * @return Constructor
     */
    public function getConstructor():Constructor;
}
