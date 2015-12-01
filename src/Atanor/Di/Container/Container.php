<?php
declare(strict_types=1);
namespace Atanor\Di\Container;

use Atanor\Di\Graph\Bond\Bond;
use Atanor\Di\Graph\Avatar\Avatar;

interface Container
{
    /**
     * @param Avatar $node
     * @return mixed
     */
    public function build(Avatar $node);
}
