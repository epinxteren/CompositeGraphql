<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

class ValueType implements HasNamespaces
{
    public function __construct(
        public ClassNamespace|string $type,
        public bool $isNullable = false,
        public ?string $defaultValue = null,
    ) {

    }

    public function getNamespaces(): array
    {
        if (is_string($this->type)) {
            return [];
        }

        return [$this->type];
    }

    public function toCode(PrinterContext $context): string
    {
        $type = $this->type instanceof ClassNamespace ? $this->type->shortName() : $this->type;

        return $this->isNullable ? sprintf('?%s', $type) : $type;
    }
}