<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;

class ArgumentType implements InputType
{
    use HasDescriptionTrait;

    public function __construct(
        private readonly Name $name,
        private readonly InputType $type,
    ) {
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getType(): InputType
    {
        return $this->type;
    }
}
