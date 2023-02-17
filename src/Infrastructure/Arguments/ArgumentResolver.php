<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Arguments;

interface ArgumentResolver
{
    public function resolves(): bool;
}
