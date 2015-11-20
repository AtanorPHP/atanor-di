<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Node;

use Atanor\Di\Graph\Node\Feature\Service;

class ServiceNode extends AbstractInstanceNode implements Service
{
    /**
     * Service name
     * @var string
     */
    protected $name;

    /**
     * @inheritdoc
     */
    public function __construct(string $name,string $typeHint)
    {
        $this->name = $name;
        $this->typeHint = $typeHint;
    }

    /**
     * @inheritDoc
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getNodeId():string
    {
        return $this->getName();
    }
}