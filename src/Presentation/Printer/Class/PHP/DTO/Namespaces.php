<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

class Namespaces
{
    public function __construct(
        /**
         * Namespaces print relative to the root namespace
         */
        public ClassNamespace $namespace,
        /**
         * @var ClassNamespace[]
         */
        public array $imports,
    ) {
    }

    public function useStatementsAsCode(PrinterContext $context): string
    {
        $all = [];
        $root = $this->namespace->root();

        foreach ($this->imports as $import) {
            $code = $import->toCode($context);
            if ($import->root() === $root) {
                continue;
            }
            $all[] = sprintf('use %s;', $code);
        }
        return implode(PHP_EOL, $all);
    }

    /**
     * Add different namespaces to the list of imports
     *
     * @param ClassNamespace[] $namespaces
     * @return self
     */
    public function add(array $namespaces): self
    {
        foreach ($namespaces as $namespace) {
            if ($this->isImported($namespace)) {
                continue;
            }
            $this->imports[] = $namespace;
        }
        return $this;
    }

    private function isImported(ClassNamespace $namespace): bool
    {
        foreach ($this->imports as $import) {
            if ($import->equals($namespace)) {
                return true;
            }
        }
        return false;
    }

}