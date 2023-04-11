<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

class ClassInstance extends Abstraction
{
    public ?Constructor $constructor = null;
    public Members $members;
    public ?ClassNamespace $extends = null;

    public function __construct(ClassNamespace $namespace)
    {
        parent::__construct($namespace);
        $this->members = new Members([]);
    }

    public function namespaces(): Namespaces
    {
        $namespaces = parent::namespaces();
        $namespaces->add($this->members->getNamespaces());
        if ($this->extends !== null) {
            $namespaces->add([$this->extends]);
        }
        if ($this->constructor !== null) {
            $namespaces->add($this->constructor->getNamespaces());
        }

        return $namespaces;
    }

}