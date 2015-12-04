<?php
declare(strict_types=1);
namespace Atanor\Di\Container;

use Atanor\Di\Graph\DiGraph;
use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Di\ObjectBuilding\Construction\Constructor;
use Atanor\Di\ObjectBuilding\Injection\Injector;

interface Materializer
{
    /**
     * @param Ghost $ghost
     * @return mixed
     */
    public function materialize(Ghost $ghost);

    /**
     * Set constructor
     * @param Constructor $constructor
     * @return Materializer
     */
    public function setConstructor(Constructor $constructor):Materializer;

    /**
     * Set injector
     * @param Injector $injector
     * @return Materializer
     */
    public function setInjector(Injector $injector):Materializer;
}
