<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure;

use GraphQL\Type\Definition\ResolveInfo;
use GuzzleHttp\Promise\PromiseInterface;

abstract class GraphQLResolver implements \CompositeGraphQL\Presentation\GraphQLResolver
{
    public function __invoke($objectValue, array $args, $context, ResolveInfo $info): PromiseInterface
    {
        return $this->resolve(new ResolverArguments($objectValue, $args, $context ?? [], $info));
    }

    abstract public function resolve(ResolverArguments $arguments): PromiseInterface;
}
