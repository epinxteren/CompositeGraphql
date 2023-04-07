<?php
declare(strict_types=1);

namespace Tests;

use CompositeGraphQL\Presentation\Value\Name;

/**
 * This class is used for testing purposes only, it is not part of the library.
 */
final class TestName implements Name
{
    public static function fromString(string $name): Name
    {
        return new self($name);
    }

    public function __construct(private string $name)
    {
    }

    public function toString(): string
    {
        return $this->name;
    }
}