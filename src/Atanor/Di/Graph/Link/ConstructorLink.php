<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Link;

use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Graph\Edge\DefaultArrow;

class ConstructorLink extends DefaultLink implements Link
{
    const PARAM_POSITION_NAME = 'position';

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

    /**
     * @inheritDoc
     */
    public function build(Ghost $tail, Ghost $head, array $params = array()):Link
    {
        $link = new self($tail,$head);
        if (isset($params[self::PARAM_POSITION_NAME])) {
            $link->setPosition($params[self::PARAM_POSITION_NAME]);
        }
        return $link;
    }


}