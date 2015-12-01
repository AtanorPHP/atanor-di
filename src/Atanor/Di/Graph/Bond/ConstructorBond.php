<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Bond;

use Atanor\Graph\Edge\DefaultArrow;

class ConstructorBond extends DefaultBond implements Bond
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
    public function setPosition($position):ConstructorBond
    {
        $this->position = $position;
        return $this;
    }


}