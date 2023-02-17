<?php

namespace CompositeGraphQL\Presentation\Contract;

interface Argument extends InputBuilder
{
    public function description(string $description): self;

    public function required(): self;

    public function asCollection(): self;

    public function type(InputBuilder $nested): self;
}
