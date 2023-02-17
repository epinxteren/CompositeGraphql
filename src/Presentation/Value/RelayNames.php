<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

/**
 * {@see https://relay.dev/graphql/connections.htm}.
 */
enum RelayNames implements Name
{
    case Node;
    case id;

    case Connection;
    case edges;
    case pageInfo;

    case Edge;
    case node;
    case cursor;

    case PageInfo;
    case hasPreviousPage;
    case hasNextPage;
    case startCursor;
    case endCursor;

    case RelayArguments;
    case first;
    case after;
    case before;
    case last;

    public function toString(): string
    {
        return $this->name;
    }
}
