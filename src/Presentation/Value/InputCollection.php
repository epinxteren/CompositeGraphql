<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

class InputCollection implements CollectionType, InputType
{
    public function __construct(
        private readonly InputType $of,
    ) {
    }

    public function of(): InputType
    {
        return $this->of;
    }

    public function getName(): Name
    {
        return $this->of->getName();
    }

    public function getDescription(): ?string
    {
        return $this->of->getDescription();
    }

    public function merge(Type $other): Type
    {
        if (!$other instanceof self) {
            throw new \InvalidArgumentException('Cannot merge with other type');
        }

        $of = $this->of->merge($other->of);
        assert($of instanceof InputType);

        return new self($of);
    }
}
