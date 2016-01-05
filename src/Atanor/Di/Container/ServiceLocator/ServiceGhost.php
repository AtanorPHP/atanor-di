<?php
declare(strict_types = 1);

namespace Atanor\Di\Container\ServiceLocator;

use Atanor\Core\Exception\ApiException;
use Atanor\Di\Graph\Ghost\DefaultGraphedGhost;
use Atanor\Di\Graph\Ghost\Feature\SingleInstance;
use Atanor\Di\Graph\Ghost\Ghost;

class ServiceGhost extends DefaultGraphedGhost implements SingleInstance
{
    /**
     * @var mixed
     */
    protected $serviceInstance;

    /**
     * @inheritDoc
     */
    public function hasStoredValue():bool
    {
        return ( ! is_null($this->serviceInstance));
    }

    /**
     * @inheritDoc
     */
    public function getStoredValue()
    {
        if ( ! $this->hasStoredValue()) {
            throw new ApiException("No stored value");
        }
        return $this->serviceInstance;
    }

    /**
     * @inheritDoc
     */
    public function storeValue(&$value):Ghost
    {
        $this->serviceInstance = $value;
        return $this;
    }

}