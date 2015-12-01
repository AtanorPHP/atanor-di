<?php
declare(strict_types = 1);

namespace Atanor\Di\Graph\Avatar;

use Atanor\Di\Graph\Avatar\Feature\IdentityProvider;
use Atanor\Di\Graph\Avatar\Feature\IdentityProviderTrait;
use Atanor\Di\Graph\Avatar\Feature\TagProviderTrait;

class DefaultServiceAvatar extends AbstractObjectAvatar implements IdentityProvider,TagProvider
{
    use IdentityProviderTrait;
    use TagProviderTrait;

    /**
     * @inheritdoc
     */
    public function __construct(string $id,string $className,array $tags = [])
    {
        $this->id = $id;
        $this->setObjectType($className);
        if (count($tags)>0) $this->addTags($tags);
    }
}