<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost;

interface FeatureAware
{
    /**
     * @param Feature $feature
     * @return Ghost
     */
    public function addFeature(Feature $feature) : FeatureAware;

    /**
     * @param string $featureClassName
     * @return Feature
     */
    public function getFeature(string $featureClassName) : Feature;

    /**
     * @param string $featureClassName
     * @return bool
     */
    public function hasFeature(string $featureClassName) : bool;
}