<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder\Traits;

use CompositeGraphQL\Presentation\Builder\ArgumentSetBuilder;
use CompositeGraphQL\Presentation\Builder\InputObjectBuilder;
use CompositeGraphQL\Presentation\Builder\OutputObjectBuilder;
use CompositeGraphQL\Presentation\Builder\ScalarBuilder;
use CompositeGraphQL\Presentation\Value\DefaultNames;
use CompositeGraphQL\Presentation\Value\Name;
use CompositeGraphQL\Presentation\Value\RelayNames;

trait BaseTypesBuilderTrait
{
    abstract public function scalar(Name $name): ScalarBuilder;

    abstract public function outputObject(Name $name): OutputObjectBuilder;

    abstract public function inputObject(Name $name): InputObjectBuilder;

    public function string(): ScalarBuilder
    {
        return $this->scalar(DefaultNames::String);
    }

    public function int(): ScalarBuilder
    {
        return $this->scalar(DefaultNames::Int);
    }

    public function float(): ScalarBuilder
    {
        return $this->scalar(DefaultNames::Float);
    }

    public function boolean(): ScalarBuilder
    {
        return $this->scalar(DefaultNames::Boolean);
    }

    public function id(): ScalarBuilder
    {
        return $this->scalar(DefaultNames::ID);
    }

    public function query(): OutputObjectBuilder
    {
        return $this->outputObject(DefaultNames::Query);
    }

    public function mutation(): InputObjectBuilder
    {
        return $this->inputObject(DefaultNames::Mutation);
    }

    public function connectionArguments(): ArgumentSetBuilder
    {
        return $this->arguments(RelayNames::RelayArguments);
    }
}
