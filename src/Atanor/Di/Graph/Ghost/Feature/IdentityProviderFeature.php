<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

use Atanor\Di\Graph\Ghost\AbstractFeature;

class IdentityProviderFeature extends AbstractFeature implements IdentityProvider
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

    /**
     * @param string $id
     * @return IdentityProvider
     */
    public function setId(string $id):IdentityProvider
    {
        $this->id = $id;
        return $this;
    }
}