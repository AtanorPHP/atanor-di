<?php
declare(strict_types = 1);
namespace Atanor\Di\Container\Registry;

use Atanor\Di\Container\AbstractContainer;

class DefaultRegistry extends AbstractContainer implements Registry
{
    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        return $this->getInstance($id);
    }

    /**
     * @inheritDoc
     */
    public function set(string $id, $value):Registry
    {
        $ghost = new RegistryEntryGhost($id,$value);
        $this->diGraph->addGhost($ghost);
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function has(string $id):bool
    {
        return $this->diGraph->containsNodeId($id);
    }

}