<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

interface UnicityProvider
{
    /**
     * @return bool
     */
    public function isMaterialized():bool;

    /**
     * @return mixed
     */
    public function getInstance();

    /**
     * @param $instance
     * @return UnicityProvider
     */
    public function setInstance($instance):UnicityProvider;
}