<?php
namespace Atanor\Di\Graph\Ghost;

interface Ghost
{
    /**
     * Return object type
     * @return string
     */
    public function getObjectType():string;

    /**
     * @param array $params
     * @return Ghost
     */
    public static function build(array $params):Ghost;
}
