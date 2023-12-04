<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Converter\Value;

final class MemberContext extends AbstractContext
{
    public function __construct(
        string $type,
        public readonly string $member,
        ?AbstractContext $parent = null,
    ) {
        parent::__construct($type, $parent);
    }
}
