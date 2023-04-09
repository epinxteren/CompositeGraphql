<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

class Func implements HasNamespaces
{
    public ValueType $returnType;

    public function __construct(
        public string $name,
        public Arguments $arguments,
        public ?string $body = null,
        ?ValueType $returnType = null,
    ) {
        $this->returnType = $returnType ?? new ValueType('void');
    }

    public function implementationCode(PrinterContext $context): string
    {
        $arguments = $this->arguments->toCode($context);
        $returnType = $this->returnType->toCode($context);

        return sprintf(
            'public function %s(%s): %s {
%s
}',
            $this->name,
            $arguments,
            $returnType,
            $this->body ? $context->indent($this->body) : ''
        );
    }

    public function contractCode(PrinterContext $context): string
    {
        $arguments = $this->arguments->toCode($context);
        $returnType = $this->returnType->toCode($context);

        return sprintf('public function %s(%s): %s;', $this->name, $arguments, $returnType);
    }

    public function getNamespaces(): array
    {
        return array_merge(
            $this->arguments->getNamespaces(),
            $this->returnType->getNamespaces(),
        );
    }
}