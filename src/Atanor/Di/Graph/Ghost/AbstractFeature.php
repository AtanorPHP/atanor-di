<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost;

abstract class AbstractFeature implements Feature
{
    /**
     * @var Ghost
     */
    protected $ghost;

    /**
     * AbstractFeature constructor.
     * @param Ghost $ghost
     */
    public function __construct(Ghost $ghost)
    {
        $this->ghost = $ghost;
    }
}