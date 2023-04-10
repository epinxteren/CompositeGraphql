<?php
declare(strict_types=1);

namespace Tests\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Builder\TypeBuilderFactory;
use CompositeGraphQL\Presentation\Value\Collections\Arguments;
use CompositeGraphQL\Presentation\Value\Collections\Interfaces;
use CompositeGraphQL\Presentation\Value\Collections\OutputFields;
use CompositeGraphQL\Presentation\Value\DefaultNames;
use CompositeGraphQL\Presentation\Value\InterfaceType;
use CompositeGraphQL\Presentation\Value\OutputCollection;
use CompositeGraphQL\Presentation\Value\OutputFieldType;
use CompositeGraphQL\Presentation\Value\OutputObject;
use CompositeGraphQL\Presentation\Value\OutputRequired;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Tests\TestName;

final class InterfaceObjectBuilderTest extends MockeryTestCase
{
    public function testBuildCached(): void
    {
        /** @var SchemaBuilder $schemaBuilder */
        list($schemaBuilder, $child, $name) = $this->buildInterface();

        $actual = $schemaBuilder->build()->getTypes()->byName($name);

        $expected = new InterfaceType(
            new TestName('People'),
            new OutputFields([
                new OutputFieldType(
                    new TestName('age'),
                    $schemaBuilder->build()->getTypes()->outputByName(DefaultNames::Int),
                ),
                new OutputFieldType(
                    new TestName('name'),
                    new OutputRequired($schemaBuilder->build()->getTypes()->outputByName(DefaultNames::String)),
                ),
                new OutputFieldType(
                    new TestName('children'),
                    new OutputRequired(
                        new OutputCollection(
                            new OutputRequired($schemaBuilder->build()->getTypes()->outputByName($child))
                        )
                    ),
                ),
                (new OutputFieldType(
                    new TestName('descendants'),
                    $schemaBuilder->build()->getTypes()->outputByName(DefaultNames::Float),
                ))->withDescription('The number of descendants'),
            ])
        );

        $this->assertEquals($expected, $actual);
    }

    public function testInterfaceFieldsAddedToOutputObject(): void
    {

        /** @var SchemaBuilder $schemaBuilder */
        list($schemaBuilder, $child, $name) = $this->buildInterface();


        $personName = new TestName('Person');
        $schemaBuilder->outputObject($personName)->implements($name);

        $interface = $schemaBuilder->build()->getTypes()->byName($name);

        $actual = $schemaBuilder->build()->getTypes()->byName($personName);

        $expected = new OutputObject(
            new TestName('Person'),
            new OutputFields([
                new OutputFieldType(
                    new TestName('age'),
                    $schemaBuilder->build()->getTypes()->outputByName(DefaultNames::Int),
                ),
                new OutputFieldType(
                    new TestName('name'),
                    new OutputRequired($schemaBuilder->build()->getTypes()->outputByName(DefaultNames::String)),
                ),
                new OutputFieldType(
                    new TestName('children'),
                    new OutputRequired(
                        new OutputCollection(
                            new OutputRequired($schemaBuilder->build()->getTypes()->outputByName($child))
                        )
                    ),
                ),
                (new OutputFieldType(
                    new TestName('descendants'),
                    $schemaBuilder->build()->getTypes()->outputByName(DefaultNames::Float),
                ))->withDescription('The number of descendants'),
            ]),
            new Interfaces([$interface])
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return [SchemaBuilder, Name, Name]
     */
    protected function buildInterface(): array
    {
        $factory = new TypeBuilderFactory();
        $schemaBuilder = new SchemaBuilder($factory);

        $child = new TestName('Child');
        $schemaBuilder
            ->interface($child)
            ->field(new TestName('age'))
            ->type($schemaBuilder->int());

        $name = new TestName('People');
        $schemaBuilder
            ->interface($name)
            ->field(new TestName('age'))
            ->type($schemaBuilder->int());

        $schemaBuilder
            ->interface($name)
            ->field(new TestName('name'))
            ->type($schemaBuilder->string())
            ->required();

        $schemaBuilder
            ->interface($name)
            ->field(new TestName('children'))
            ->type($schemaBuilder->interface($child))
            ->required()
            ->asCollection();

        $schemaBuilder
            ->interface($name)
            ->field(new TestName('descendants'))
            ->type($schemaBuilder->float())
            ->description('The number of descendants');

        return array($schemaBuilder, $child, $name);
    }
}
