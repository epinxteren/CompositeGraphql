<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Contract\OutputBuilder;
use CompositeGraphQL\Presentation\Contract\RelayConnection;
use CompositeGraphQL\Presentation\Value\DynamicName;
use CompositeGraphQL\Presentation\Value\Name;
use CompositeGraphQL\Presentation\Value\RelayNames;

class RelayConnectionBuilder extends OutputObjectBuilder implements RelayConnection
{
    private readonly OutputObjectBuilder $edge;
    private readonly OutputObjectBuilder $pageInfo;

    public static function create(SchemaBuilder $builder, Name $name, Name $node): self
    {
        $connectionNane = new DynamicName($name, RelayNames::Connection);

        $instance = new self($connectionNane, $builder);

        $builder->outputObject($name)->interface(RelayNames::Node);

        $instance->pageInfo = $builder
            ->outputObject(new DynamicName($name, RelayNames::PageInfo))
            ->interface(RelayNames::PageInfo);

        $instance->edge = $builder->outputObject(new DynamicName($name, RelayNames::Edge))
                ->interface(RelayNames::Edge);
        $instance->edge
            ->field(RelayNames::node)
            ->type($builder->outputObject($node))->required();

        $instance->interface(RelayNames::Connection);
        $instance->field(RelayNames::pageInfo)->type($instance->pageInfo)->required();
        $instance->field(RelayNames::edges)->type($instance->edge)->asCollection()->required();

        return $instance;
    }

    public function getEdge(): OutputObjectBuilder
    {
        return $this->edge;
    }

    public function getPageInfo(): OutputObjectBuilder
    {
        return $this->pageInfo;
    }

    public function type(OutputBuilder $nested): self
    {
        $this->edge->field(RelayNames::node)->type($nested);

        return $this;
    }
}
