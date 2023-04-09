<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

class Abstraction implements HasNamespaces
{
    public Interfaces $interfaces;
    public Functions $functions;

    public function __construct(public ClassNamespace $namespace)
    {
        $this->interfaces = new Interfaces();
        $this->functions = new Functions([]);
    }

    public function namespaces(): Namespaces
    {
        $namespaces = new Namespaces($this->namespace, []);
        return $namespaces
            ->add($this->interfaces->getNamespaces())
            ->add($this->functions->getNamespaces());
    }

    public function getNamespaces(): array
    {
        return [$this->namespace];
    }
}