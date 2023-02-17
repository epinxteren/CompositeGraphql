<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value\Collections;

use CompositeGraphQL\Presentation\Value\ArgumentType;
use CompositeGraphQL\Presentation\Value\Type;

/**
 * @extends AbstractCollection<ArgumentType>
 */
class Arguments extends AbstractCollection
{
    public function isValid(Type $normalized): bool
    {
        return $normalized instanceof ArgumentType;
    }
}
