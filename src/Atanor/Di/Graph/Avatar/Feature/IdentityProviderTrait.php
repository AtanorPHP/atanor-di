<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Avatar\Feature;

trait IdentityProviderTrait
{
    /**
     * Object ID
     * @var string
     */
    protected $id;
    /**
     *
     * IdentityProvider name
     * @return string
     */
    public function getId():string
    {
        return $this->id;
    }

    /**
     * return graph node id
     * @return string
     */
    public function getNodeId():string
    {
        return $this->getId();
    }
}