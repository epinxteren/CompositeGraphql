<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value\Collections;

use CompositeGraphQL\Presentation\Value\InterfaceType;
use CompositeGraphQL\Presentation\Value\Type;

/**
 * @extends AbstractCollection<\CompositeGraphQL\Presentation\Value\InterfaceType>
 */
class Interfaces extends AbstractCollection
{
    public function isValid(Type $normalized): bool
    {
        return $normalized instanceof InterfaceType;
    }
}
