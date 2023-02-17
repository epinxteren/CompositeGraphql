<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\TypeProvider;

use CompositeGraphQL\Presentation\Contract\SchemaBuilder;
use CompositeGraphQL\Presentation\TypeProvider;
use CompositeGraphQL\Presentation\Value\RelayNames;

class RelayTypeProvider implements TypeProvider
{
    private const RELAY_URL = 'https://relay.dev/graphql/connections.htm';

    public function composeTypes(SchemaBuilder $builder): void
    {
        $pageInfoInterface = $builder->interface(RelayNames::PageInfo);
        $pageInfoInterface->description(
            sprintf('Base info, according to the Relay specification. (%s)', self::RELAY_URL),
        );
        $pageInfoInterface->field(RelayNames::hasPreviousPage)->type($builder->boolean())->required();
        $pageInfoInterface->field(RelayNames::hasNextPage)->type($builder->boolean())->required();
        $pageInfoInterface->field(RelayNames::startCursor)->type($builder->string());
        $pageInfoInterface->field(RelayNames::endCursor)->type($builder->string());

        $connectionInterface = $builder->interface(RelayNames::Connection);
        $connectionInterface->description(
            sprintf('Base connection, according to the Relay specification. (%s)', self::RELAY_URL),
        );
        $connectionInterface->field(RelayNames::pageInfo)->type($pageInfoInterface)->required();

        $nodeInterface = $builder->interface(RelayNames::Node);
        $nodeInterface->description(
            sprintf('Base node, according to the Relay specification. (%s)', self::RELAY_URL),
        );
        $nodeInterface->field(RelayNames::id)->type($builder->id())->required();

        $edgeInterface = $builder->interface(RelayNames::Edge);
        $edgeInterface->description(
            sprintf('Base edge, according to the Relay specification. (%s)', self::RELAY_URL),
        );
        $edgeInterface->field(RelayNames::cursor)->type($builder->string())->required();
        $edgeInterface->field(RelayNames::node)->type($nodeInterface)->required();

        $connectionArguments = $builder->arguments(RelayNames::RelayArguments);
        $connectionArguments
            ->argument(RelayNames::first)
            ->description('takes a non-negative integer')
            ->type($builder->int());

        $connectionArguments
            ->argument(RelayNames::last)
            ->description('takes a non-negative integer')
            ->type($builder->int());

        $connectionArguments
            ->argument(RelayNames::after)
            ->type($builder->string());

        $connectionArguments
            ->argument(RelayNames::before)
            ->type($builder->string());
    }
}
