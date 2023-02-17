<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure;

use GraphQL\Type\Definition\ResolveInfo;

class ResolverArguments implements \CompositeGraphQL\Presentation\ResolverArguments
{
    public function __construct(public readonly mixed $data, public readonly array $args, public readonly array $context, public readonly ResolveInfo $info)
    {
    }

    public function arg(string $name): mixed
    {
        assert(isset($this->args[$name]));

        return $this->args[$name];
    }
}
