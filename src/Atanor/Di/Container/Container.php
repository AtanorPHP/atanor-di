<?php
declare(strict_types = 1);
namespace Atanor\Di\Container;

use Atanor\Di\Graph\DiGraph;
use Interop\Container\ContainerInterface;
use Atanor\Di\Graph\Ghost\Ghost;

interface Container extends Wizard, ContainerInterface
{
    /**
     * Set Di graph
     * @param DiGraph $graph
     * @return Container
     */
    public function setDiGraph(DiGraph $graph):Container;

    /**
     * Return di graph
     * @return DiGraph
     */
    public function getDiGraph():DiGraph;

    /**
     * @param $id
     * @return Ghost
     */
    public function getGhost($id):Ghost;

    /**
     * @param $item
     * @param string $id
     * @return mixed
     */
    public function addItem($item,string $id = null);

    /**
     * @param string $objectType
     * @param string|null $ghostClass
     * @param array|null $params
     * @param string|null $id
     * @return Container
     */
    public function addGhost(string $objectType, string $ghostClass = null, array $params = null, string $id = null):Ghost;
}