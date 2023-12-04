<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Converter;

use CompositeGraphQL\Presentation\Contract\SchemaBuilder;
use CompositeGraphQL\Presentation\Converter\Value\AbstractContext;

interface ConverterInterface
{

    public function convert(
        AbstractContext $context,
        SchemaBuilder $builder
    ): void;

}
