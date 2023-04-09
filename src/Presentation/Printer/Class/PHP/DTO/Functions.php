<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

class Functions implements HasNamespaces
{
    public function __construct(
        /**
         * @var Func[]
         */
        public array $functions,
    ) {
    }

    public function implementationCode(PrinterContext $context): string
    {
        return implode(PHP_EOL . PHP_EOL, array_map(fn(Func $func) => $func->implementationCode($context), $this->functions));
    }

    public function contractCode(PrinterContext $context): string
    {
        return implode(PHP_EOL . PHP_EOL, array_map(fn(Func $func) => $func->contractCode($context), $this->functions));
    }

    public function getNamespaces(): array
    {
        return array_reduce(
            $this->functions,
            fn(array $namespaces, Func $func) => array_merge($namespaces, $func->getNamespaces()),
            []
        );
    }

}