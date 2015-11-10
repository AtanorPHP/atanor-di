<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Edge;

use Atanor\Graph\Edge\DefaultArrow;

class ConstructorParamEdge extends DefaultArrow implements DependencyEdge
{
    /**
     * Constructor parameter position
     * @var int
     */
    protected $position;

    /**
     * Returns parameter position
     * @return int
     */
    public function getPosition():int
    {
        return $this->position;
    }

    /**
     * Set parameter position
     * @param int $position
     */
    public function setPosition($position):ConstructorParamEdge
    {
        $this->position = $position;
        return $this;
    }


}