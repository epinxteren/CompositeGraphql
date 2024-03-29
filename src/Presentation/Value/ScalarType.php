<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Value\Traits\HasMergeAbleTrait;

final class ScalarType implements InputType, OutputType
{
    use HasMergeAbleTrait;
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
        return $this->mergeCommon($other, fn(self $o) => new self($this->name));
    }
}
