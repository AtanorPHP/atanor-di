<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Node;

use Atanor\Di\Graph\Node\Feature\Entity;

class EntityNode extends AbstractInstanceNode implements Entity
{
    /**
     * Entity id
     * @var string
     */
    protected $id;

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getNodeId():string
    {
        $nodeId = $this->getTypeHint() . '::' . $this->id;
    }

}