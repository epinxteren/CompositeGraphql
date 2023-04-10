<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Collections\OutputFields;
use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Value\Traits\HasMergeAbleTrait;

class InterfaceType implements OutputType
{
    use HasMergeAbleTrait;
    use HasDescriptionTrait;

    public function __construct(
        private readonly Name $name,
        private readonly OutputFields $fields,
    ) {
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getFields(): OutputFields
    {
        return $this->fields;
    }

    public function merge(Type $other): Type
    {
        return $this
            ->mergeCommon($other, fn(self $o) => new self($this->name, $this->fields->merge($o->fields)));
    }
}
