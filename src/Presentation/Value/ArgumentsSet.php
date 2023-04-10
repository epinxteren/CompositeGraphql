<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Collections\Arguments;
use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Value\Traits\HasMergeAbleTrait;

final class ArgumentsSet implements InputType
{
    use HasMergeAbleTrait;
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

    public function merge(Type $other): Type
    {
        return $this
            ->mergeCommon($other, fn(self $o) => new self($this->name, $this->arguments->merge($o->arguments)));
    }
}
