<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Symfony;

use CompositeGraphQL\Presentation\Value\ResolverReference;
use Symfony\Component\DependencyInjection\Reference;

final class SymfonyServiceReference extends Reference implements ResolverReference
{
}
