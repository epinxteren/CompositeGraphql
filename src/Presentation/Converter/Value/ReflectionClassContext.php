<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Converter\Value;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Value\Name;
use ReflectionClass;

final class ReflectionClassContext extends AbstractContext
{
    public function __construct(
        Name $name,
        SchemaBuilder $builder,
        public readonly ReflectionClass $class,
        ?AbstractContext $parent = null
    )
    {
        parent::__construct($builder, $name, $parent);
    }

    public function property(\ReflectionProperty $property): ReflectionPropertyContext
    {
        return new ReflectionPropertyContext(
            $this->builder,
            new TemporaryConverterName($property->getName()),
            $property,
            $this
        );
    }
}
