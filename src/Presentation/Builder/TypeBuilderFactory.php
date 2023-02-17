<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Contract\TypeBuilder;
use CompositeGraphQL\Presentation\Value\Name;

class TypeBuilderFactory
{
    private SchemaBuilder $builder;

    public function setBuilder(SchemaBuilder $builder): void
    {
        $this->builder = $builder;
    }

    /**
     * @template T extends TypeBuilder
     *
     * @param class-string<T> $class
     *
     * @return T
     */
    public function create(Name $name, string $class): TypeBuilder
    {
        return new $class($name, $this->builder);
    }
}
