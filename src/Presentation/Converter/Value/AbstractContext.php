<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Converter\Value;

use CompositeGraphQL\Presentation\Contract\SchemaBuilder;
use CompositeGraphQL\Presentation\Value\Name;

abstract class AbstractContext
{
    public function __construct(
        public readonly SchemaBuilder $builder,
        public readonly Name $name,
        public readonly ?self $parent = null,
    ) {
    }
}
