<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Link;

use Atanor\Di\ObjectBuilding\Injection\Dependency\Dependency;
use Atanor\Graph\Edge\DefaultArrow;

class DefaultLink extends DefaultArrow implements Link
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function setValue($value):Dependency
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public static function build(array $params):Link
    {
        return new static();
    }


}
