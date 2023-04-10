<?php

namespace CompositeGraphQL\Presentation\Contract;

use CompositeGraphQL\Presentation\Value\Name;

interface OutputObject extends OutputBuilder
{
    public function description(string $description): self;

    public function implements(Name $name): self;

    public function field(Name $name): OutputField;
}
