<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Collections\Interfaces;
use CompositeGraphQL\Presentation\Value\Collections\OutputFields;
use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Value\Traits\HasMergeAbleTrait;

class OutputObject implements OutputType
{
    use HasMergeAbleTrait;
    use HasDescriptionTrait;

    private readonly OutputFields $fields;
    private readonly Interfaces $interfaces;

    public function __construct(
        private readonly Name $name,
        OutputFields $fields,
        ?Interfaces $interfaces = null,
    ) {
        $this->interfaces = $interfaces ?? new Interfaces([]);
        $this->fields = $fields->addInterfaceFields($this->interfaces);
    }

    public function getInterfaces(): Interfaces
    {
        return $this->interfaces;
    }

    /**
     * @return OutputFields
     */
    public function getFields(): OutputFields
    {
        return $this->fields;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function merge(Type $other): Type
    {
        return $this
            ->mergeCommon($other, fn(self $o) => new self(
                $this->name,
                $this->fields->merge($o->fields),
                $this->interfaces->merge($o->interfaces)
            ));
    }
}
