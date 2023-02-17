<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Collections\InputFields;
use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;

class InputObject implements InputType
{
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
}
