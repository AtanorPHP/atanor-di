<?php
declare(strict_types=1);
namespace Atanor\Di\Graph\Node\Feature;

use Atanor\Graph\Node\NodeIdProvider;

interface Service extends NodeIdProvider
{
    /**
     * Service name
     * @return string
     */
    public function getName():string;

    /**
     * Service constructor.
     * @param string $name
     * @param string $typeHint
     */
    public function __construct(string $name,string $typeHint);

}
