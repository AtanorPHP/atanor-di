<?php
namespace Atanor\Di\Graph\Avatar;

interface Avatar
{
    /**
     * Returns true if avatar has been materialized
     * @return bool
     */
    public function isMaterialized():bool;

    /**
     * Returns inner object
     * @return mixed
     */
    public function getObject();

    /**
     * Set instance
     * @param $object
     * @return Avatar
     */
    public function setObject(&$object):Avatar;

    /**
     * Return object type
     * @return string
     */
    public function getObjectType():string;
}
