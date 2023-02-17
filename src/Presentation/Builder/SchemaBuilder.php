<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\Traits\BaseTypesBuilderTrait;
use CompositeGraphQL\Presentation\Contract\InterfaceObject;
use CompositeGraphQL\Presentation\Contract\SchemaBuilder as SchemaBuilderInterface;
use CompositeGraphQL\Presentation\Contract\TypeBuilder;
use CompositeGraphQL\Presentation\Value\Collections\Collection;
use CompositeGraphQL\Presentation\Value\Name;
use CompositeGraphQL\Presentation\Value\Schema;

final class SchemaBuilder implements SchemaBuilderInterface
{
    use BaseTypesBuilderTrait;

    private bool $mutable = true;

    /**
     * @var BuilderCollection<TypeBuilder>
     */
    private BuilderCollection $types;

    public function __construct(private readonly TypeBuilderFactory $factory)
    {
        $factory->setBuilder($this);
        $this->types = new BuilderCollection();
    }

    public function interface(Name $name): InterfaceObject
    {
        return $this->types->byName($name, $this->factory->create($name, InterfaceObjectBuilder::class));
    }

    public function outputObject(Name $name): OutputObjectBuilder
    {
        return $this->types->byName($name, $this->factory->create($name, OutputObjectBuilder::class));
    }

    public function inputObject(Name $name): InputObjectBuilder
    {
        return $this->types->byName($name, $this->factory->create($name, InputObjectBuilder::class));
    }

    public function arguments(Name $name): ArgumentSetBuilder
    {
        return $this->types->byName($name, $this->factory->create($name, ArgumentSetBuilder::class));
    }

    public function scalar(Name $name): ScalarBuilder
    {
        return $this->types->byName($name, $this->factory->create($name, ScalarBuilder::class));
    }

    public function connection(Name $name, Name $node): RelayConnectionBuilder
    {
        $fallback = RelayConnectionBuilder::create($this, $name, $node);

        return $this->types->byName($fallback->getName(), $fallback);
    }

    public function build(): Schema
    {
        $this->mutable = false;
        $query = $this->query();
        assert($query instanceof OutputObjectBuilder);
        $mutation = $this->mutation();
        assert($mutation instanceof InputObjectBuilder);

        return new Schema(
            $query->buildOutput(),
            $mutation->buildInput(),
            new Collection($this->types->build()),
        );
    }

    public function assertMutable(): void
    {
        assert($this->mutable);
    }

    public function assertLocked(): void
    {
        assert($this->mutable === false);
    }
}
