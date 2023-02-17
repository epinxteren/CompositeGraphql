<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure;

use CompositeGraphQL\Presentation\Value\Type;
use Symfony\Component\DependencyInjection\Definition;

interface DefinitionFactory extends ReferenceFactory
{
    public function create(Type $type, ReferenceFactory $reference): Definition;
}
