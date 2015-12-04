<?php
declare(strict_types = 1);
namespace Atanor\Di\Container\Registry;

use Atanor\Di\Container\Container;

interface Registry extends Container
{
    /**
     * Return instance having this id
     * @param string $id
     * @return mixed
     */
    public function get(string $id);

    /**
     * Set new entry
     * @param string $id
     * @param $value
     * @return Registry
     */
    public function set(string $id,$value):Registry;

    /**
     * True if registry having this id
     * @param string $id
     * @return bool
     */
    public function has(string $id):bool;
}