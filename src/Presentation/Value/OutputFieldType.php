<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Collections\AbstractCollection;
use CompositeGraphQL\Presentation\Value\Collections\Arguments;
use CompositeGraphQL\Presentation\Value\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Value\Traits\HasMergeAbleTrait;

class OutputFieldType implements OutputType
{
    use HasMergeAbleTrait;
    use HasDescriptionTrait;

    private readonly Arguments $arguments;

    public function __construct(
        private readonly Name $name,
        private readonly OutputType $type,
        ?Arguments $arguments = null,
        private readonly ?ResolverReference $resolverServiceReference = null,
    ) {
        $this->arguments = $arguments ?? new Arguments([]);
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getType(): OutputType
    {
        return $this->type;
    }

    public function getArguments(): AbstractCollection
    {
        return $this->arguments;
    }

    public function getResolverServiceReference(): ?ResolverReference
    {
        return $this->resolverServiceReference;
    }

    public function merge(Type $other): Type
    {
        return $this
            ->mergeCommon($other, function (self $o) {
                $type = $this->type->merge($o->type);
                assert($type instanceof OutputType);

                return new self(
                    $this->name,
                    $type,
                    $this->arguments->merge($o->arguments),
                    $this->resolverServiceReference ?? $o->resolverServiceReference
                );
            });
    }
}
