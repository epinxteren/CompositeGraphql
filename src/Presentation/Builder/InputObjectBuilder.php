<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Builder\Traits\HasInputFieldsTrait;
use CompositeGraphQL\Presentation\Contract\InputObject;
use CompositeGraphQL\Presentation\Value\InputType;

class InputObjectBuilder extends AbstractInputBuilder implements InputObject
{
    use HasDescriptionTrait;
    use HasInputFieldsTrait;

    public function buildCached(): InputType
    {
        return (new \CompositeGraphQL\Presentation\Value\InputObject(
            $this->getName(),
            $this->buildFields(),
        ))->withDescription($this->getDescription());
    }
}
