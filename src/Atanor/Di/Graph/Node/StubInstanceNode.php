<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Node;

use Atanor\Di\Graph\Node\Feature\NodeIdProvider;

class StubInstanceNode implements InstanceNode,NodeIdProvider
{
    /**
     * @var string
     */
    protected $id;

    /**
     * StubInstanceNode constructor.
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function getTypeHint()
    {
        return 'stub';
    }

    /**
     * @inheritDoc
     */
    public function isInstantiated():bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getInstance()
    {
        throw new \Exception('You cannot instantiate a stub instance node');
    }

    /**
     * @inheritDoc
     */
    public function setInstance(&$instance):InstanceNode
    {
        throw new \Exception('You cannot instantiate a stub instance node');
    }

    /**
     * @inheritDoc
     */
    public function getId():string
    {
        return $this->id;
    }




}