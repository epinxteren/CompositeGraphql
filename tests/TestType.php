<?php
declare(strict_types=1);

namespace Tests;

use CompositeGraphQL\Presentation\Value\Name;
use CompositeGraphQL\Presentation\Value\Type;

class TestType implements Type {

    public function getName(): Name
    {
        return new TestName('MyType');
    }

    public function getDescription(): ?string
    {
        return null;
    }
}