<?php
declare(strict_types=1);
namespace Atanor\Di\ObjectBuilding\Injection;

interface Injector
{
    /**
     * Inject dependency instances into the target instance
     * Returns true if inejction was ok.
     * @param mixed $targetInstance
     * @param \ArrayAccess|\Traversable|array $dependencyList
     * @return mixed
     */
    public function inject(&$targetInstance,$dependencyList);

    /**
     * Injector constructor.
     */
    public function __construct();
}
