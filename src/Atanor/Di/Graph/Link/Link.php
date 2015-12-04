<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Link;

use Atanor\Di\Graph\Ghost\Ghost;
use Atanor\Graph\Edge\Arrow;

interface Link extends Arrow
{
    /**
     * Empty constructor
     * Link constructor.
     */
    public function __construct(Ghost $tail,Ghost $head);
}