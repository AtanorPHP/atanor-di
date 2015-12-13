<?php
declare(strict_types = 1);
namespace Atanor\Di\Graph\Ghost\Feature;

interface UnicityProvider extends StorageProvider
{
    /**
     * @return bool
     */
    public function isMaterialized():bool;

    /**
     * @return mixed
     */
    public function getInsatnce();
}