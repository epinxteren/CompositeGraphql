<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder\Traits;

use CompositeGraphQL\Presentation\Builder\BuilderCollection;
use CompositeGraphQL\Presentation\Builder\OutputFieldBuilder;
use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Value\Collections\OutputFields;
use CompositeGraphQL\Presentation\Value\Name;

trait HasOutputFieldsTrait
{
    /**
     * @var BuilderCollection<OutputFieldBuilder>|null
     */
    private ?BuilderCollection $fields;

    public function field(Name $name): OutputFieldBuilder
    {
        $this->root()->assertMutable();

        return $this->getFields()->byName($name, new OutputFieldBuilder($name, $this->root()));
    }

    public function getFields(): BuilderCollection
    {
        return $this->fields ??= new BuilderCollection();
    }

    private function buildFields(): OutputFields
    {
        $this->root()->assertLocked();

        return new OutputFields($this->getFields()->build());
    }

    abstract public function root(): SchemaBuilder;
}
