<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

interface LabeledGhost
{
    /**
     * Return array of tags
     * @return array
     */
    public function getTags():array;

    /**
     * Add a tag
     * @param string $tag
     * @return LabeledGhost
     */
    public function addTag(string $tag):LabeledGhost;
}