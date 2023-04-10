<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

interface Type
{
    public function getName(): Name;

    public function getDescription(): ?string;

    /**
     * Merges the two types into one.
     *
     * @param Type $other
     * @return Type
     */
    public function merge(Type $other): Type;
}
