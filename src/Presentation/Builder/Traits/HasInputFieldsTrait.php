<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder\Traits;

use CompositeGraphQL\Presentation\Builder\BuilderCollection;
use CompositeGraphQL\Presentation\Builder\InputFieldBuilder;
use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Value\Collections\InputFields;
use CompositeGraphQL\Presentation\Value\Name;

trait HasInputFieldsTrait
{
    /**
     * @var BuilderCollection<InputFieldBuilder>|null
     */
    private ?BuilderCollection $fields;

    public function field(Name $name): InputFieldBuilder
    {
        $this->root()->assertMutable();

        return $this->getFields()->byName($name, new InputFieldBuilder($name, $this->root()));
    }

    public function getFields(): BuilderCollection
    {
        return $this->fields ??= new BuilderCollection();
    }

    protected function buildFields(): InputFields
    {
        $this->root()->assertLocked();

        return new InputFields($this->getFields()->build());
    }

    abstract public function root(): SchemaBuilder;
}
