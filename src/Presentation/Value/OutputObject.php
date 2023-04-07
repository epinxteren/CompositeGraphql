<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Collections\Arguments;
use CompositeGraphQL\Presentation\Value\Collections\Interfaces;
use CompositeGraphQL\Presentation\Value\Collections\OutputFields;
use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;

class OutputObject implements OutputType
{
    use HasDescriptionTrait;
    private readonly OutputFields $fields;

    public function __construct(
        private readonly Name $name,
        private readonly Arguments $arguments,
        OutputFields $fields,
        private readonly Interfaces $interfaces,
    ) {
        $this->fields = $fields->addInterfaceFields($interfaces);
    }

    public function getInterfaces(): Interfaces
    {
        return $this->interfaces;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getArguments(): Arguments
    {
        return $this->arguments;
    }

    public function getFields(): OutputFields
    {
        return $this->fields;
    }

    public function mergeInterface(Interfaces $interfaces): self
    {
        return new self(
            $this->name,
            $this->arguments,
            $this->fields->addInterfaceFields($interfaces),
            $this->interfaces->merge($interfaces),
        );
    }
}
