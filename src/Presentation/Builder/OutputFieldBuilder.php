<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\Traits\HasArgumentsTrait;
use CompositeGraphQL\Presentation\Builder\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Builder\Traits\HasOutputTypeTrait;
use CompositeGraphQL\Presentation\Builder\Traits\HasResolverTrait;
use CompositeGraphQL\Presentation\Contract\OutputField;
use CompositeGraphQL\Presentation\Value\OutputFieldType;
use CompositeGraphQL\Presentation\Value\OutputType;

class OutputFieldBuilder extends AbstractOutputBuilder implements OutputField
{
    use HasArgumentsTrait;
    use HasResolverTrait;
    use HasDescriptionTrait;
    use HasOutputTypeTrait;

    public function buildCached(): OutputType
    {
        return (new OutputFieldType(
            $this->getName(),
            $this->buildType(),
            $this->buildArguments(),
            $this->getResolverServiceReference(),
        ))->withDescription($this->getDescription());
    }
}
