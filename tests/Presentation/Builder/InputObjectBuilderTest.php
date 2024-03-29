<?php
declare(strict_types=1);

namespace Tests\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Builder\TypeBuilderFactory;
use CompositeGraphQL\Presentation\Value\Collections\InputFields;
use CompositeGraphQL\Presentation\Value\DefaultNames;
use CompositeGraphQL\Presentation\Value\InputCollection;
use CompositeGraphQL\Presentation\Value\InputFieldType;
use CompositeGraphQL\Presentation\Value\InputObject;
use CompositeGraphQL\Presentation\Value\InputRequired;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Tests\TestName;

final class InputObjectBuilderTest extends MockeryTestCase
{

    public function testBuildCached(): void
    {
        $factory = new TypeBuilderFactory();
        $schemaBuilder = new SchemaBuilder($factory);

        $child = new TestName('Child');
        $schemaBuilder
            ->inputObject($child)
            ->field(new TestName('age'))
            ->type($schemaBuilder->int());

        $name = new TestName('People');
        $schemaBuilder
            ->inputObject($name)
            ->field(new TestName('age'))
            ->type($schemaBuilder->int());

        $schemaBuilder
            ->inputObject($name)
            ->field(new TestName('name'))
            ->type($schemaBuilder->string())
            ->required();

        $schemaBuilder
            ->inputObject($name)
            ->field(new TestName('children'))
            ->type($schemaBuilder->inputObject($child))
            ->required()
            ->asCollection();

        $schemaBuilder
            ->inputObject($name)
            ->field(new TestName('descendants'))
            ->type($schemaBuilder->float())
            ->description('The number of descendants');

        $actual = $schemaBuilder->build()->getTypes()->byName($name);

        $expected = new InputObject(
            new TestName('People'),
            new InputFields([
                new InputFieldType(
                    new TestName('age'),
                    $schemaBuilder->build()->getTypes()->inputByName(DefaultNames::Int),
                ),
                new InputFieldType(
                    new TestName('name'),
                    new InputRequired($schemaBuilder->build()->getTypes()->inputByName(DefaultNames::String)),
                ),
                new InputFieldType(
                    new TestName('children'),
                    new InputRequired(
                        new InputCollection(
                            new InputRequired($schemaBuilder->build()->getTypes()->inputByName($child))
                        )
                    ),
                ),
                (new InputFieldType(
                    new TestName('descendants'),
                    $schemaBuilder->build()->getTypes()->inputByName(DefaultNames::Float),
                ))->withDescription('The number of descendants'),
            ])
        );

        $this->assertEquals($expected, $actual);
    }
}
