<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Contract;

use CompositeGraphQL\Presentation\Value\InputType;

interface InputBuilder extends TypeBuilder
{
    public function buildInput(): InputType;
}
