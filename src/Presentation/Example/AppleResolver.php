<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Example;

use CompositeGraphQL\Infrastructure\GraphQLResolver;
use CompositeGraphQL\Infrastructure\ResolverArguments;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\PromiseInterface;

class AppleResolver extends GraphQLResolver
{
    public function resolve(ResolverArguments $arguments): PromiseInterface
    {
        return Create::promiseFor([
            [
                'pageInfo' => [
                    'hasPreviousPage' => true,
                    'hasNextPage' => true,
                    'startCursor' => null,
                    'endCursor' => null,
                ],
                'edges' => [
                    [
                        'cursor' => '1',
                        'node' => [
                            'color' => 'red',
                        ],
                    ],
                    [
                        'cursor' => '2',
                        'node' => [
                            'color' => 'red',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
