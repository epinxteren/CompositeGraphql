<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder\Traits;

use CompositeGraphQL\Presentation\Builder\BuilderCollection;
use CompositeGraphQL\Presentation\Builder\InterfaceObjectBuilder;
use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Value\Collections\Interfaces;
use CompositeGraphQL\Presentation\Value\Name;

trait HasInterfaceTrait
{
    /**
     * @var BuilderCollection<InterfaceObjectBuilder>|null
     */
    private ?BuilderCollection $interfaces;

    public function implements(Name $name): self
    {
        $this->root()->assertMutable();
        $this->getInterfaces()->byName($name, $this->root()->interface($name));

        return $this;
    }

    private function getInterfaces(): BuilderCollection
    {
        return $this->interfaces ??= new BuilderCollection();
    }

    private function buildInterfaces(): Interfaces
    {
        $this->root()->assertLocked();

        return new Interfaces($this->getInterfaces()->build());
    }

    abstract public function root(): SchemaBuilder;
}
