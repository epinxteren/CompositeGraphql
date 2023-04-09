<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

class Members implements HasNamespaces
{
    public function __construct(
        /**
         * @var Member[]
         */
        public array $members,
    ) {
    }

    public function toCode(PrinterContext $context): string
    {
        return implode(
            PHP_EOL,
            array_map(fn(Member $member) => sprintf("public %s;", $member->toCode($context)), $this->members)
        );
    }

    public function getNamespaces(): array
    {
        return array_reduce(
            $this->members,
            fn(array $namespaces, Member $member) => array_merge($namespaces, $member->getNamespaces()),
            []
        );
    }
}