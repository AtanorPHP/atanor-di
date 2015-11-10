<?php
namespace Atanor\Di\Container;

interface EntityManager
{
    public function getEntity($className,$identity);
}
