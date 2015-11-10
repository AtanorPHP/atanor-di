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
     * @return bool
     */
    public function inject(&$targetInstance,$dependencyList):bool;
}
