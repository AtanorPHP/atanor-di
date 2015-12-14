<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost;

abstract class AbstractFeaturedGhost implements Ghost, FeatureAware
{
    /**
     * Plugins collection
     * @var array
     */
    protected $features = [];

    /**
     * @inheritdoc
     */
    public function addFeature(Feature $feature):FeatureAware
    {
        $key = get_class($feature);
        $this->features[$key] = $feature;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFeatures():array
    {
        return $this->features;
    }

    /**
     * @inheritdoc
     */
    public function getFeature(string $featureClassName):Feature
    {
        if ( ! $this->hasFeature($featureClassName)) {
            //@todo trhow exception
        }
        return $this->features[$featureClassName];
    }

    /**
     * @inheritdoc
     */
    public function hasFeature(string $featureClassName):bool
    {
        return isset($this->features[$featureClassName]);
    }

    /**
     * @inheritDoc
     */
    public static function build(array $params):Ghost
    {
        if (isset($params['ghostClassName'])) {
            $ghostClass = $params['ghostClassName'];
            $ghost = new $ghostClass();
        }
        else $ghost = new static();
        return $ghost;
    }


}