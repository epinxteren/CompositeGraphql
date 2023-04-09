<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

class Member extends ValueType
{
    public function __construct(
        public string $name,
        ClassNamespace|string $type,
        bool $isNullable = false,
        ?string $defaultValue = null
    ) {
        parent::__construct($type, $isNullable, $defaultValue);
    }

    public function toCode(PrinterContext $context): string
    {
        $type = parent::toCode($context);
        if ($this->defaultValue) {
            return sprintf('%s %s = %s', $type, $this->name, $this->defaultValue);
        }

        return sprintf('%s %s', $type, $this->name);
    }
}