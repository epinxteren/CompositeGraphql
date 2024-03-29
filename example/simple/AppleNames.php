<?php

declare(strict_types=1);

namespace Example\simple;

use CompositeGraphQL\Presentation\Value\Name;

enum AppleNames implements Name
{
    case Apple;
    case color;
    case weight;

    case apples;
    case changeColor;

    case Apples;

    public function toString(): string
    {
        return $this->name;
    }
}
