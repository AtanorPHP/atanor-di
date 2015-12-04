<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

use Atanor\Graph\Node\NodeIdProvider;

interface Entity extends NodeIdProvider
{
    /**
     * Return id
     * @return string
     */
    public function getId();
}
