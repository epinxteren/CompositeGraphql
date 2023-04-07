<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Collections\Arguments;
use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;

final class ArgumentsSet implements InputType
{
    use HasDescriptionTrait;

    public function __construct(private Name $name, private Arguments $arguments)
    {
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getArguments(): Arguments
    {
        return $this->arguments;
    }
}
