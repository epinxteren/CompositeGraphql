<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Collections\OutputFields;
use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;

class InterfaceType implements OutputType
{
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
}
