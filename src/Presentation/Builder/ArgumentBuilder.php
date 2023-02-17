<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Builder\Traits\HasInputTypeTrait;
use CompositeGraphQL\Presentation\Contract\Argument;
use CompositeGraphQL\Presentation\Value\ArgumentType;

class ArgumentBuilder extends AbstractInputBuilder implements Argument
{
    use HasDescriptionTrait;
    use HasInputTypeTrait;

    protected function buildCached(): ArgumentType
    {
        return new ArgumentType(
            $this->getName(),
            $this->buildType(),
        );
    }
}
