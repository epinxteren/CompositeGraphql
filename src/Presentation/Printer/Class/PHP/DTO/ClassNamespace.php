<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

class ClassNamespace
{
    public function __construct(
        public string $namespace,
        public ?string $alias = null,
        public ?string $shortName = null,
    ) {
    }

    public function toCode(PrinterContext $context): string
    {
        return $this->alias ? sprintf('%s as %s', $this->namespace, $this->alias) : $this->namespace;
    }

    /**
     * The root namespace of the class.
     *
     * @return string
     */
    public function root(): string
    {
        $parts = explode('\\', $this->namespace);

        $slices = array_slice($parts, 0, -1);

        return implode('\\', $slices);
    }

    public function shortName(): string
    {
        if ($this->shortName) {
            return $this->shortName;
        }

        $parts = explode('\\', $this->namespace);

        return end($parts);
    }

    public function equals(ClassNamespace $namespace): bool
    {
        return $this->namespace === $namespace->namespace && $this->alias === $namespace->alias;
    }

}