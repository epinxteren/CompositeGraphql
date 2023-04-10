<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;

final class UndefinedType implements InputType, OutputType
{
    use HasDescriptionTrait;

    public function __construct(
        private readonly Name $name,
    ) {
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function merge(Type $other): Type
    {
        return $other;
    }
}
