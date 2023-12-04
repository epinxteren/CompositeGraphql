<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Converter\Value;

use CompositeGraphQL\Presentation\Value\Name;

/**
 * @internal
 */
final class TemporaryConverterName implements Name
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
