<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value\Collections;

use CompositeGraphQL\Presentation\Value\InputFieldType;
use CompositeGraphQL\Presentation\Value\Type;

/**
 * @extends AbstractCollection<InputFieldType>
 */
class InputFields extends AbstractCollection
{
    public function isValid(Type $normalized): bool
    {
        return $normalized instanceof InputFieldType;
    }
}
