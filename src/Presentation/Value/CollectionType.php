<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

interface CollectionType extends Type
{
    public function of(): Type;
}
