<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

interface RequiredType extends Type
{
    public function of(): Type;
}
