<?php

namespace CompositeGraphQL\Presentation\Contract;

use CompositeGraphQL\Presentation\Value\Name;

/**
 * Set of arguments, can be added to any output field.
 */
interface ArgumentSet extends InputBuilder
{
    public function argument(Name $name): Argument;
}
