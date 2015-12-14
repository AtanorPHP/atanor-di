<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Link;

use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Graph\Edge\Arrow;

interface Link extends Arrow
{
    /**
     * @param Ghost $tail
     * @param Ghost $head
     * @param array $params
     * @return Link
     */
    public function build(Ghost $tail,Ghost $head,array $params = array()):Link;
}