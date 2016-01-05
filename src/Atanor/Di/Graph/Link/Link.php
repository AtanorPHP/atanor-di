<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Link;

use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;
use Atanor\Graph\Edge\Arrow;

interface Link extends Arrow,Dependency
{
    /**
     * @param array $params
     * @return Link
     */
    public static function build(array $params):Link;
}