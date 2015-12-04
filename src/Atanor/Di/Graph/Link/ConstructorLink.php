<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Link;

use Atanor\Graph\Edge\DefaultArrow;

class ConstructorLink extends DefaultLink implements Link
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
    public function setPosition($position):ConstructorLink
    {
        if ( ! $this->position !== null) return $this;
        $this->position = $position;
        return $this;
    }


}