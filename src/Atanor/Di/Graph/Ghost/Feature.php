<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost;

interface Feature
{
    /**
     * Feature constructor.
     * @param Ghost $ghost
     */
    public function __construct(Ghost $ghost);

    /**
     * @param array $params
     * @return Feature
     */
    public static function build(Ghost $ghost,array $params):Feature;
}