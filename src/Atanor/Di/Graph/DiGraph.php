<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph;

use Atanor\Di\Graph\Link\Link;
use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Graph\Graph\Graph;

interface DiGraph extends Graph
{
    /**
     * Add avatar
     * @param Ghost $ghost
     * @return DiGraph
     */
    public function addGhost(Ghost $ghost):DiGraph;

    /**
     * Add bond
     * @param Link $link
     * @return DiGraph
     */
    public function addLink(Link $link):DiGraph;

    /**
     * Get all dependencies
     * @param Ghost $ghost
     * @return mixed
     */
    public function getDependencyLinks(Ghost $ghost):array;

    /**
     * Returns true if node as dependencies
     * @param Ghost $ghost
     * @return bool
     */
    public function hasDependencyLinks(Ghost $ghost):bool;

    /**
     * Return dependencies of a node as dependency objects
     * Callback callable is used to generate the dependency value from dependency nodes.
     * @param Ghost $ghost
     * @param callable $materializationCallback
     * @return mixed
     */
    public function getDependencyObjects(Ghost $ghost, $materializationCallback):array;

    /**
     * Return contructor parameter as key value pair
     * @param Ghost $ghost
     * @param $materializationCallback
     * @return mixed
     */
    public function getConstructorParams(Ghost $ghost, $materializationCallback):array;
}