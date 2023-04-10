<?php
declare(strict_types=1);

namespace Tests\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Builder\TypeBuilderFactory;
use CompositeGraphQL\Presentation\Value\Collections\OutputFields;
use CompositeGraphQL\Presentation\Value\DefaultNames;
use CompositeGraphQL\Presentation\Value\OutputCollection;
use CompositeGraphQL\Presentation\Value\OutputFieldType;
use CompositeGraphQL\Presentation\Value\OutputObject;
use CompositeGraphQL\Presentation\Value\OutputRequired;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Tests\TestName;

final class OutputObjectBuilderTest extends MockeryTestCase
{
    public function testBuildCached(): void
    {
        $factory = new TypeBuilderFactory();
        $schemaBuilder = new SchemaBuilder($factory);

        $child = new TestName('Child');
        $schemaBuilder
            ->outputObject($child)
            ->field(new TestName('age'))
            ->type($schemaBuilder->int());

        $name = new TestName('People');
        $schemaBuilder
            ->outputObject($name)
            ->field(new TestName('age'))
            ->type($schemaBuilder->int());

        $schemaBuilder
            ->outputObject($name)
            ->field(new TestName('name'))
            ->type($schemaBuilder->string())
            ->required();

        $schemaBuilder
            ->outputObject($name)
            ->field(new TestName('children'))
            ->type($schemaBuilder->outputObject($child))
            ->required()
            ->asCollection();

        $schemaBuilder
            ->outputObject($name)
            ->field(new TestName('descendants'))
            ->type($schemaBuilder->float())
            ->description('The number of descendants');

        $actual = $schemaBuilder->build()->getTypes()->byName($name);

        $expected = new OutputObject(
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
}
