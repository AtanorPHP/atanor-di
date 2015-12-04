<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Link;

use Atanor\Graph\Edge\DefaultArrow;
use Atanor\Di\Graph\Ghost\Ghost;

class DefaultLink extends DefaultArrow implements  Link
{
    /**
     * DefaultLink constructor.
     */
    public function __construct(Ghost $tail,Ghost $head)
    {
        $this->setEnds($tail,$head);
    }
}
