<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Contract;

use CompositeGraphQL\Presentation\Value\OutputType;

interface OutputBuilder extends TypeBuilder
{
    public function buildOutput(): OutputType;
}
