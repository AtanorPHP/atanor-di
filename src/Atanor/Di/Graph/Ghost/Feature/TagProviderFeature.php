<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

use Atanor\Di\Graph\Ghost\AbstractFeature;

class TagProviderFeature extends AbstractFeature implements TagProvider
{
    /**
     * Tags list
     * @var array
     */
    protected $tags =[];

    /**
     * Return array of tags
     * @return array
     */
    public function getTags():array
    {
        return $this->tags;
    }

    /**
     * Add a tag
     * @param string $tag
     * @return TagProvider
     */
    public function addTag(string $tag):TagProvider
    {
        if (in_array($tag,$this->tags)) return $this;
        $this->tags[] = $tag;
    }

    /**
     * Add many tags
     * @param array $tags
     * @return TagProvider
     */
    public function addTags(array $tags):TagProvider
    {
        foreach($tags as $tag) {
            $this->addTag($tag);
        }
        return $this;
    }
}