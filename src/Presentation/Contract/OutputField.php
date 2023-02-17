<?php

namespace CompositeGraphQL\Presentation\Contract;

use CompositeGraphQL\Presentation\Value\Name;
use CompositeGraphQL\Presentation\Value\ResolverReference;

interface OutputField extends OutputBuilder
{
    public function argument(Name $name): Argument;

    public function addArgumentSet(ArgumentSet $arguments): self;

    public function description(string $description): self;

    public function required(): self;

    public function asCollection(): self;

    public function type(OutputBuilder $nested): self;

    public function resolver(ResolverReference $resolverServiceReference): self;
}
