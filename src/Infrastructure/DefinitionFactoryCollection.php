<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure;

use Assert\Assertion;
use CompositeGraphQL\Presentation\Value\Type;

class DefinitionFactoryCollection
{
    public function __construct(private array $factories)
    {
        Assertion::allIsInstanceOf($factories, DefinitionFactory::class);
    }

    public function toArray(): array
    {
        return $this->factories;
    }

    public function getBy(Type $type): DefinitionFactory
    {
        foreach ($this->factories as $factory) {
            if ($factory->satisfy($type)) {
                return $factory;
            }
        }
        throw new \RuntimeException(sprintf('No factory found for type %s', $type->getName()->toString()));
    }

    public function satisfy(Type $type): bool
    {
        foreach ($this->factories as $factory) {
            if ($factory->satisfy($type)) {
                return true;
            }
        }

        return false;
    }
}
