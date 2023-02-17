<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\Traits\HasArgumentsTrait;
use CompositeGraphQL\Presentation\Contract\ArgumentSet;
use CompositeGraphQL\Presentation\Value\ArgumentsSet;
use CompositeGraphQL\Presentation\Value\InputType;

/**
 * Set of arguments, can be added to any field.
 */
class ArgumentSetBuilder extends AbstractInputBuilder implements ArgumentSet
{
    use HasArgumentsTrait;

    public function buildCached(): InputType
    {
        return new ArgumentsSet($this->getName(), $this->buildArguments());
    }
}
