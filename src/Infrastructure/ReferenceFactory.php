<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure;

use CompositeGraphQL\Presentation\Value\Type;
use Symfony\Component\DependencyInjection\Reference;

interface ReferenceFactory
{
    public function createReference(Type $type): Reference;

    public function satisfy(Type $type): bool;
}
