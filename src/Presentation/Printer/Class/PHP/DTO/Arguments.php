<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

class Arguments implements HasNamespaces
{
    /**
     * @var Argument[]
     */
    public array $arguments;

    public function __construct(
        Argument ...$arguments,
    ) {
        $this->arguments = $arguments;
    }

    public function toCode(PrinterContext $context): string
    {
        $count = count($this->arguments);
        if ($count <= 2) {
            return implode(', ', array_map(fn(Argument $argument) => $argument->toCode($context), $this->arguments));
        }

        return PHP_EOL.
            $context->indent(
                implode(','.PHP_EOL, array_map(fn(Argument $argument) => $argument->toCode($context), $this->arguments))
            );
    }

    /**
     * Quick and dirty way to get the arguments as public members.
     */
    public function asPublicMembers(PrinterContext $context): string
    {
        $count = count($this->arguments);
        if ($count <= 2) {
            return implode(
                ', ',
                array_map(fn(Argument $argument) => 'public '.$argument->toCode($context), $this->arguments)
            );
        }

        return PHP_EOL.
            $context->indent(
                implode(
                    ','.PHP_EOL,
                    array_map(fn(Argument $argument) => 'public '.$argument->toCode($context), $this->arguments)
                )
            );
    }

    public function getNamespaces(): array
    {
        return array_reduce(
            $this->arguments,
            fn(array $namespaces, Argument $argument) => array_merge($namespaces, $argument->getNamespaces()),
            []
        );
    }

}