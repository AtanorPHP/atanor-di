<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost;

class DefaultGhost implements Ghost, FeatureAware
{
    /**
     * @var string
     */
    protected $objectType;

    /**
     * Plugins collection
     * @var array
     */
    protected $features = [];

    /**
     * @inheritDoc
     */
    public function getObjectType():string
    {
        return $this->objectType;
    }

    /**
     * @param Feature $feature
     * @return Ghost
     */
    public function addFeature(Feature $feature):Ghost
    {
        $key = get_class($feature);
        $this->features[$key] = $feature;
    }

    /**
     * @param string $featureClassName
     * @return Feature
     */
    public function getFeature(string $featureClassName):Feature
    {
        if ( ! $this->hasFeature($featureClassName)) {
            //@todo trhow exception
        }
        return $this->features[$featureClassName];
    }

    /**
     * @param string $featureClassName
     * @return bool
     */
    public function hasFeature(string $featureClassName):bool
    {
        return isset($this->features[$featureClassName]);
    }

}