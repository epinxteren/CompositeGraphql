<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Contract\InputBuilder;
use CompositeGraphQL\Presentation\Contract\Scalar;
use CompositeGraphQL\Presentation\Value\InputType;
use CompositeGraphQL\Presentation\Value\OutputType;
use CompositeGraphQL\Presentation\Value\ScalarType;

class ScalarBuilder extends AbstractOutputBuilder implements InputBuilder, Scalar
{
    use HasDescriptionTrait;

    protected function buildCached(): OutputType
    {
        return new ScalarType($this->getName());
    }

    public function buildInput(): InputType
    {
        $outputType = $this->buildOutput();
        assert($outputType instanceof ScalarType);

        return $outputType;
    }
}
