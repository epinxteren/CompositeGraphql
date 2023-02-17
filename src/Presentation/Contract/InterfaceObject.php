<?php

namespace CompositeGraphQL\Presentation\Contract;

use CompositeGraphQL\Presentation\Value\Name;

interface InterfaceObject extends OutputBuilder
{
    public function description(string $description): self;

    public function field(Name $name): OutputField;
}
