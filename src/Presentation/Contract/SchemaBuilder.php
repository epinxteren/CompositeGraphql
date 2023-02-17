<?php

namespace CompositeGraphQL\Presentation\Contract;

use CompositeGraphQL\Presentation\Value\Name;
use CompositeGraphQL\Presentation\Value\Schema;

/**
 * During build time all can be modified, but after build is invoked it is immutable.
 */
interface SchemaBuilder
{
    public function interface(Name $name): InterfaceObject;

    public function query(): OutputObject;

    public function mutation(): InputObject;

    public function connectionArguments(): ArgumentSet;

    public function inputObject(Name $name): InputObject;

    public function outputObject(Name $name): OutputObject;

    public function connection(Name $name, Name $node): RelayConnection;

    public function arguments(Name $name): ArgumentSet;

    public function scalar(Name $name): Scalar;

    public function string(): Scalar;

    public function int(): Scalar;

    public function float(): Scalar;

    public function boolean(): Scalar;

    public function id(): Scalar;

    public function build(): Schema;
}
