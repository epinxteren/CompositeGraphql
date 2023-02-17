<?php

namespace CompositeGraphQL\Presentation;

interface ResolverArguments
{
    public function arg(string $name): mixed;
}
