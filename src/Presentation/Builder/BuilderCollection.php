<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Contract\InputBuilder;
use CompositeGraphQL\Presentation\Contract\OutputBuilder;
use CompositeGraphQL\Presentation\Contract\TypeBuilder;
use CompositeGraphQL\Presentation\Value\Name;

/**
 * @template T extends TypeBuilder
 */
class BuilderCollection
{
    /**
     * @var array<string, T>
     */
    private array $types = [];

    public function has(Name $name): bool
    {
        $key = $name->toString();

        return isset($this->types[$key]);
    }

    /**
     * Always returns the same instance for the same name.
     *
     * @param ?T $typeFallBack
     *
     * @return T
     */
    public function byName(Name $name, ?TypeBuilder $typeFallBack = null): TypeBuilder
    {
        $key = $name->toString();
        if (!isset($this->types[$key])) {
            if (!$typeFallBack) {
                throw new \RuntimeException(sprintf('Name %s is not defined',
                    $name->toString(),
                ));
            }
            $this->types[$key] = $typeFallBack;
        }
        $instance = $this->types[$key];
        if (!$typeFallBack) {
            return $instance;
        }

        $class1 = get_class($instance);
        $class2 = get_class($typeFallBack);
        if ($class1 !== $class2) {
            throw new \RuntimeException(sprintf('Name %s is used for 2 different types of builders (%s and %s)',
                $name->toString(),
                $class1,
                $class2,
            ));
        }

        return $instance;
    }

    /**
     * @return \CompositeGraphQL\Presentation\Value\Type[]
     */
    public function build(): array
    {
        $build = [];
        foreach ($this->types as $type) {
            if ($type instanceof InputBuilder) {
                $build[] = $type->buildInput();
            }
            if ($type instanceof OutputBuilder) {
                $build[] = $type->buildOutput();
            }
        }

        return $build;
    }

    /**
     * @return array<string, T>
     */
    public function getTypes(): array
    {
        return $this->types;
    }
}
