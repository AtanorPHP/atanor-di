<?php
namespace Atanor\Di\Graph\Ghost;

interface Ghost
{
    /**
     * Returns true if ghost has been materialized
     * @return bool
     */
    public function isMaterialized():bool;

    /**
     * Return inner object
     * @return mixed
     */
    public function getObject();

    /**
     * Set instance
     * @param $object
     * @return Ghost
     */
    public function setObject(&$object):Ghost;

    /**
     * Return object type
     * @return string
     */
    public function getObjectType():string;
}
