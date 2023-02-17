<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Builder\TypeBuilderFactory;
use CompositeGraphQL\Presentation\Value\Schema;

class SchemaFactory
{
    public function create(TypeProvider ...$providers): Schema
    {
        $builder = new SchemaBuilder(new TypeBuilderFactory());
        foreach ($providers as $provider) {
            $provider->composeTypes($builder);
        }

        return $builder->build();
    }
}
