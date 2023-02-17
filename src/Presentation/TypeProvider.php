<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation;

use CompositeGraphQL\Presentation\Contract\SchemaBuilder;

interface TypeProvider
{
    public function composeTypes(SchemaBuilder $builder): void;
}
