<?php

namespace CompositeGraphQL\Presentation\Contract;

use CompositeGraphQL\Presentation\Value\Name;

interface OutputObject extends OutputBuilder
{
    public function argument(Name $name): Argument;

    public function addArgumentSet(ArgumentSet $arguments): self;

    public function description(string $description): self;

    public function interface(Name $name): self;

    public function field(Name $name): OutputField;
}
