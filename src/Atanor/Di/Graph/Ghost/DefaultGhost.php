<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost;

class DefaultGhost implements Ghost
{
    /**
     * @var string
     */
    protected $objectType;

    /**
     * @inheritDoc
     */
    public function setObjectType(string $objectType):Ghost
    {
        $this->objectType = $objectType;
        return $this;
    }



    /**
     * @inheritDoc
     */
    public function getObjectType():string
    {
        return $this->objectType;
    }

    /**
     * @inheritdoc
     */
    public static function build(array $params):Ghost
    {
        if (isset($params['type'])) {
            $ghostClass = $params['type'];
            unset($params['type']);
            return $ghostClass::build($params);
        }
        else $ghost = new static();
        $ghost->setObjectType($params['objectType']);
        return $ghost;
    }

}
