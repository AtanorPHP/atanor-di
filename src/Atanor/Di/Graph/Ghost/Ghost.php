<?php
namespace Atanor\Di\Graph\Ghost;


interface Ghost
{
    /**
     * @param string $objectType
     * @return Ghost
     */
    public function setObjectType(string $objectType):Ghost;

    /**
     * @return string
     */
    public function getObjectType():string;

    /**
     * @param array $param
     * @return Ghost
     */
    public static function build(array $param):Ghost;
}
