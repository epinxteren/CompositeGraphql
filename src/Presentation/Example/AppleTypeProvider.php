<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Example;

use CompositeGraphQL\Infrastructure\Symfony\SymfonyServiceReference;
use CompositeGraphQL\Presentation\Contract\SchemaBuilder;
use CompositeGraphQL\Presentation\TypeProvider;

class AppleTypeProvider implements TypeProvider
{
    public function composeTypes(SchemaBuilder $builder): void
    {
        $builder
            ->outputObject(AppleNames::Apple)
            ->description('Nice apple with a color and a weight')
            ->field(AppleNames::color)
            ->type($builder->string())
            ->required();

        $builder
            ->mutation()
            ->field(AppleNames::changeColor)
            ->type($builder->string())
            ->required();

        $builder
            ->query()
            ->relayConnectionField(AppleNames::Apples, AppleNames::Apple)
            ->resolver(new SymfonyServiceReference(AppleResolver::class));
    }
}
