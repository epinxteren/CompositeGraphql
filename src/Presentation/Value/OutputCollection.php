<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Traits\HasMergeAbleTrait;

class OutputCollection implements CollectionType, OutputType
{
    use HasMergeAbleTrait;

    public function __construct(
        private readonly OutputType $of,
    ) {
    }

    public function of(): OutputType
    {
        return $this->of;
    }

    public function getName(): Name
    {
        return $this->of->getName();
    }

    public function getDescription(): ?string
    {
        return $this->of->getDescription();
    }

    public function merge(Type $other): Type
    {
        return $this->mergeCommon($other, function (self $o) {
            $of = $this->of->merge($o->of);
            assert($of instanceof OutputType);
            return new self($of);
        });
    }
}
