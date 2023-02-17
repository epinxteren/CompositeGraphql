<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Contract;

use CompositeGraphQL\Presentation\Value\Name;

/**
 * During build time it can be modified, but after build is invoked it is immutable.
 */
interface TypeBuilder
{
    public function getName(): Name;
}
