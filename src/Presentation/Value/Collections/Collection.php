<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value\Collections;

use CompositeGraphQL\Presentation\Value\InputFieldType;
use CompositeGraphQL\Presentation\Value\OutputFieldType;
use CompositeGraphQL\Presentation\Value\Type;

final class Collection extends AbstractCollection
{
    public function isValid(Type $normalized): bool
    {
        return true;
    }

    public function inputs(): InputFields
    {
        return new InputFields($this->filter(fn (Type $type) => $type instanceof InputFieldType));
    }

    public function outputs(): OutputFields
    {
        return new OutputFields($this->filter(fn (Type $type) => $type instanceof OutputFieldType));
    }
}
