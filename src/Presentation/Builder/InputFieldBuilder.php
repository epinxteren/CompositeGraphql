<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Builder\Traits\HasInputTypeTrait;
use CompositeGraphQL\Presentation\Contract\InputBuilder;
use CompositeGraphQL\Presentation\Contract\InputField;
use CompositeGraphQL\Presentation\Value\InputFieldType;
use CompositeGraphQL\Presentation\Value\InputType;

class InputFieldBuilder extends AbstractInputBuilder implements InputBuilder, InputField
{
    use HasDescriptionTrait;
    use HasInputTypeTrait;

    public function buildCached(): InputType
    {
        return (new InputFieldType(
            $this->getName(),
            $this->buildType(),
        ))->withDescription($this->getDescription());
    }
}
