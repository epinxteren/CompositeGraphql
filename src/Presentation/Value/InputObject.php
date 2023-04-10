<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Collections\InputFields;
use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Value\Traits\HasMergeAbleTrait;

class InputObject implements InputType
{
    use HasMergeAbleTrait;
    use HasDescriptionTrait;

    public function __construct(
        private Name $name,
        private InputFields $fields,
    ) {
    }

    public function getFields(): InputFields
    {
        return $this->fields;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function merge(Type $other): Type
    {
        return $this
            ->mergeCommon($other, fn(self $o) => new self($this->name, $this->fields->merge($o->fields)));
    }
}
