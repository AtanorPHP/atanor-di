<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph;

use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Graph\Graph\DirectedGraph;

interface DiGraph extends DirectedGraph
{
    /**
     * Return dependencies of a node as dependency objects
     * Callback callable is used to generate the dependency value from dependency nodes.
     * @param Ghost $ghost
     * @param callable $materializationCallback
     * @return mixed
     */
    public function getDependencies(Ghost $ghost, $materializationCallback):array;

    /**
     * Return contructor parameter as key value pair
     * @param Ghost $ghost
     * @param $invocationCallback
     * @return mixed
     */
    public function getConstructorDependencies(Ghost $ghost, $invocationCallback):array;

    /**
     * @param Ghost $ghost
     * @return bool
     */
    public function hasConstructorDependencies(Ghost $ghost):bool;

    /**
     * @param Ghost $ghost
     * @param $invocationCallback
     * @return mixed
     */
    public function getInjectableDependencies(Ghost $ghost, $invocationCallback):array;

    /**
     * @param Ghost $ghost
     * @return bool
     */
    public function hasInjectableDependencies(Ghost $ghost):bool;

    /**
     * @param Ghost $ghost
     * @param $value
     * @param string $property
     * @return DiGraph
     */
    public function addPropertyDependency(Ghost $ghost,$value,string $property):DiGraph;

    /**
     * @param Ghost $ghost
     * @param $value
     * @param int $position
     * @return DiGraph
     */
    public function addConstructorDependency(Ghost $ghost,$value,int $position):DiGraph;
}