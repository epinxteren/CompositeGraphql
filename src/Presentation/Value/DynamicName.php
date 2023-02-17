<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value;

final class DynamicName implements Name
{
    public function __construct(private Name $name, private Name $postfix)
    {
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getPostfix(): Name
    {
        return $this->postfix;
    }

    public function toString(): string
    {
        return sprintf('%s%s', $this->name->toString(), $this->postfix->toString());
    }
}
