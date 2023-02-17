<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

use CompositeGraphQL\Presentation\Value\Collections\Collection;

class Schema
{
    public function __construct(
        private OutputObject $query,
        private InputObject $mutation,
        private Collection $types,
    ) {
    }

    public function getQuery(): OutputObject
    {
        return $this->query;
    }

    public function getMutation(): InputObject
    {
        return $this->mutation;
    }

    public function getTypes(): Collection
    {
        return $this->types;
    }
}
