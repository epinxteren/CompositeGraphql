<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\TypeProvider;

use CompositeGraphQL\Presentation\Contract\SchemaBuilder;
use CompositeGraphQL\Presentation\TypeProvider;

class DefaultTypeProvider implements TypeProvider
{
    public function composeTypes(SchemaBuilder $builder): void
    {
        $builder->query();
        $builder->mutation();
    }
}
