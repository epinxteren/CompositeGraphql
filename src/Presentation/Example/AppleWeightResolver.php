<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Example;

use CompositeGraphQL\Infrastructure\GraphQLResolver;
use CompositeGraphQL\Infrastructure\ResolverArguments;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;

class AppleWeightResolver extends GraphQLResolver
{
    public function resolve(ResolverArguments $arguments): PromiseInterface
    {
        return Create::promiseFor(0.1);
    }
}
