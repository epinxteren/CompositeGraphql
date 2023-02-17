<?php

namespace CompositeGraphQL\Presentation\Contract;

use CompositeGraphQL\Presentation\Value\Name;

interface InputObject extends InputBuilder
{
    public function description(string $description): self;

    public function field(Name $name): InputField;
}
