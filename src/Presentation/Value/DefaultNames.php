<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

enum DefaultNames implements Name
{
    /*
     * Root objects
     */
    case Query;
    case Mutation;

    /*
     * Scalars
     */
    case String;
    case Int;
    case Float;
    case Boolean;
    case ID;

    public function toString(): string
    {
        return $this->name;
    }
}
