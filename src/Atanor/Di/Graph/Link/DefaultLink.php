<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Link;

use Atanor\Graph\Edge\DefaultArrow;
use Atanor\Di\Graph\Ghost\Ghost;

class DefaultLink extends DefaultArrow implements  Link
{
    /**
     * @inheritDoc
     */
    public function build(Ghost $tail, Ghost $head, array $params = array()):Link
    {
        $link = new self($tail,$head);
        return $link;
    }


}
