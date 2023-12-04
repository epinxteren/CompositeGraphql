<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Converter\Value;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Value\Name;
use \ReflectionProperty;

final class ReflectionPropertyContext extends AbstractContext
{
    public function __construct(
        SchemaBuilder $builder,
        Name $name,
        public readonly ReflectionProperty $property,
        public readonly ReflectionClassContext $class
    )
    {
        parent::__construct($builder, $name, $class);
    }
}
