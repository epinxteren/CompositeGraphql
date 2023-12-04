<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Converter;

use CompositeGraphQL\Presentation\Contract\InputObject;
use CompositeGraphQL\Presentation\Contract\OutputObject;

final class TypeContainer
{
    /**
     * @var array<class-string, InputObject>
     */
    private array $inputTypes = [];

    /**
     * @var array<class-string, OutputObject>
     */
    private array $outputTypes = [];

    /**
     * @param class-string $className
     */
    public function resolveInputType(string $className): ?InputObject
    {
        return $this->inputTypes[$className] ?? null;
    }

    public function resolveOutputType(string $className): ?OutputObject
    {
        return $this->outputTypes[$className] ?? null;
    }

    public function registerInputType(string $className, InputObject $builder): void
    {
        $this->inputTypes[$className] = $builder;
    }

    public function registerOutputType(string $className, OutputObject $builder): void
    {
        $this->outputTypes[$className] = $builder;
    }
}
