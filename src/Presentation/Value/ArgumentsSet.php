<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Collections\Arguments;

class ArgumentsSet implements InputType
{
    public function __construct(private Name $name, private Arguments $arguments)
    {
    }

    public function isValid(Type $normalized): bool
    {
        return $normalized instanceof ArgumentType;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getArguments(): Arguments
    {
        return $this->arguments;
    }

    public function getDescription(): ?string
    {
        return '';
    }
}
