<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Builder\Traits\HasOutputFieldsTrait;
use CompositeGraphQL\Presentation\Contract\InterfaceObject;
use CompositeGraphQL\Presentation\Value\InterfaceType;
use CompositeGraphQL\Presentation\Value\OutputType;

class InterfaceObjectBuilder extends AbstractOutputBuilder implements InterfaceObject
{
    use HasDescriptionTrait;
    use HasOutputFieldsTrait;

    protected function buildCached(): OutputType
    {
        return (new InterfaceType(
            $this->getName(),
            $this->buildFields(),
        ))->withDescription($this->getDescription());
    }
}
