<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder\Traits;

use CompositeGraphQL\Presentation\Builder\ArgumentBuilder;
use CompositeGraphQL\Presentation\Builder\ArgumentSetBuilder;
use CompositeGraphQL\Presentation\Builder\BuilderCollection;
use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Contract\Argument;
use CompositeGraphQL\Presentation\Contract\ArgumentSet;
use CompositeGraphQL\Presentation\Value\Collections\Arguments;
use CompositeGraphQL\Presentation\Value\Name;

trait HasArgumentsTrait
{
    /**
     * @var BuilderCollection<ArgumentBuilder>|null
     */
    private ?BuilderCollection $arguments;

    /**
     * @var ArgumentSetBuilder[]
     */
    private array $sets = [];

    private ?Arguments $cache = null;

    public function argument(Name $name): Argument
    {
        $this->root()->assertMutable();

        return $this->getArguments()->byName($name, new ArgumentBuilder($name, $this->root()));
    }

    public function addArgumentSet(ArgumentSet $arguments): self
    {
        $this->root()->assertMutable();

        $this->sets[] = $arguments;

        return $this;
    }

    private function getArguments(): BuilderCollection
    {
        return $this->arguments ??= new BuilderCollection();
    }

    protected function buildArguments(): Arguments
    {
        $this->root()->assertLocked();
        $args = new Arguments($this->getArguments()->build());
        foreach ($this->sets as $set) {
            $arguments = $set->normalizedArguments();
            $args = $args->merge($arguments);
        }
        return $args;
    }

    public function normalizedArguments(): Arguments
    {
        return $this->cache ??= $this->buildArguments();
    }

    abstract public function root(): SchemaBuilder;
}
