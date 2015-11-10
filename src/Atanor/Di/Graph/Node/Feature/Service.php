<?php
declare(strict_types=1);
namespace Atanor\Di\Graph\Node\Feature;

interface Service extends NodeIdProvider
{
    const OPTION_SERVICE_NAME = 'serviceName';

    /**
     * Service name
     * @return string
     */
    public function getName():string;
}
