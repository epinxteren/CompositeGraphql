<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value\Collections;

use CompositeGraphQL\Presentation\Value\Name;
use CompositeGraphQL\Presentation\Value\Type;

/**
 * @template T extends Normalized
 */
abstract class AbstractCollection
{
    /**
     * @var T[];
     */
    private array $types = [];

    /**
     * @param array<string, T> $types
     */
    final public function __construct(array $types)
    {
        $this->types = $types;
        foreach ($types as $type) {
            assert($this->isValid($type));
        }
    }

    public function has(Name $name): bool
    {
        $key = $name->toString();
        foreach ($this->types as $type) {
            if ($type->getName()->toString() === $key) {
                return true;
            }
        }

        return false;
    }

    public function add(Type $normalized): self
    {
        assert($this->isValid($normalized));

        return new static(
            array_merge([], $this->types, [
                $normalized->getName()->toString() => $normalized,
            ]),
        );
    }

    /**
     * @return T
     */
    public function byName(Name $name): Type
    {
        $key = $name->toString();
        foreach ($this->types as $type) {
            if ($type->getName()->toString() === $key) {
                return $type;
            }
        }
        throw new \RuntimeException(
            sprintf(
                'Name %s is not defined',
                $name->toString(),
            ),
        );
    }

    /**
     * @return array<string, T>
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    abstract public function isValid(Type $normalized): bool;

    /**
     * @template TReturn
     *
     * @param callable(T): TReturn $callback
     *
     * @return array<string, T>
     */
    public function map(callable $callback): array
    {
        return array_map($callback, $this->types);
    }

    public function filter(callable $param): self
    {
        return new static(array_filter($this->types, $param));
    }

    public function sortFirstBy(string ...$classes): static
    {
        return new static(
            array_merge(
                $this->filter(fn (Type $type) => in_array(get_class($type), $classes))->sortBy(...$classes)->getTypes(),
                $this->filter(fn (Type $type) => !in_array(get_class($type), $classes))->getTypes(),
            ),
        );
    }

    public function sortBy(string ...$classes): static
    {
        $sorted = [];
        foreach ($classes as $class) {
            $sorted = array_merge($sorted, $this->filter(fn (Type $type) => get_class($type) === $class)->getTypes());
        }

        return new static($sorted);
    }

    public function sort(callable $param): static
    {
        $types = $this->getTypes();
        usort($types, $param);

        return new static($types);
    }

    public function isEmpty(): bool
    {
        return empty($this->types);
    }

    public function merge(Interfaces $interfaces): static
    {
        return new static(array_merge([], $this->types, $interfaces->types));
    }
}