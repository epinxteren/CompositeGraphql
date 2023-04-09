<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

class Interfaces implements HasNamespaces
{
    /**
     * @var ClassNamespace[]
     */
    public array $interfaces;

    public function __construct(
        ClassNamespace ...$interfaces
    ) {
        $this->interfaces = $interfaces;
    }

    public function toCode(PrinterContext $context): string
    {
        return implode(
            ', ',
            array_map(fn(ClassNamespace $interface) => $interface->toCode($context), $this->interfaces)
        );
    }

    public function getNamespaces(): array
    {
        return array_reduce(
            $this->interfaces,
            fn(array $namespaces, ClassNamespace $interface) => array_merge($namespaces, [$interface]),
            []
        );
    }

    public function empty(): bool
    {
        return empty($this->interfaces);
    }

}