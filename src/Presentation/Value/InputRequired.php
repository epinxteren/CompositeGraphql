<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

class InputRequired implements RequiredType, InputType
{
    public function __construct(
        private readonly InputType $of,
    ) {
    }

    public function of(): Type
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
}
