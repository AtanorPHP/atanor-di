<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph;

use Atanor\Di\Graph\Bond\Bond;
use Atanor\Di\Graph\Avatar\Avatar;
use Atanor\Graph\Graph\Graph;

interface AvatarGraph extends Graph
{
    /**
     * Add avatar
     * @param Avatar $avatar
     * @return AvatarGraph
     */
    public function addAvatar(Avatar $avatar):AvatarGraph;

    /**
     * Add bond
     * @param Bond $bond
     * @return AvatarGraph
     */
    public function addBond(Bond $bond):AvatarGraph;

    /**
     * Get all dependencies
     * @param Avatar $avatar
     * @return mixed
     */
    public function getDependencyBonds(Avatar $avatar):array;

    /**
     * Returns true if node as dependencies
     * @param Avatar $avatar
     * @return bool
     */
    public function hasDependencyBonds(Avatar $avatar):bool;

    /**
     * Return dependencies of a node as dependency objects
     * Callback callable is used to generate the dependency value from dependency nodes.
     * @param Avatar $avatar
     * @param callable $instantiationCallback
     * @return mixed
     */
    public function getDependencyObjects(Avatar $avatar, $instantiationCallback):array;
}