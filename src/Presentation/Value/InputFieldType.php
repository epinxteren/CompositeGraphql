<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Value\Traits\HasMergeAbleTrait;

class InputFieldType implements InputType
{
    use HasMergeAbleTrait;
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

    public function merge(Type $other): Type
    {
        return $this
            ->mergeCommon($other, function (self $o) {
                $type = $this->type->merge($o->type);
                assert($type instanceof InputType);

                return new self($this->name, $type);
            });
    }
}
