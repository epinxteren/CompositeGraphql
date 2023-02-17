<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Example;

use CompositeGraphQL\Infrastructure\Symfony\SymfonyServiceReference;
use CompositeGraphQL\Presentation\Contract\SchemaBuilder;
use CompositeGraphQL\Presentation\TypeProvider;

final class AppleExtendTypeProvider implements TypeProvider
{
    public function composeTypes(SchemaBuilder $builder): void
    {
        $builder
            ->outputObject(AppleNames::Apple)
            ->field(AppleNames::weight)
            ->type($builder->float())
            ->resolver(new SymfonyServiceReference(AppleWeightResolver::class))
            ->required();
    }
}
