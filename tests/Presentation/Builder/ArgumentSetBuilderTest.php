<?php
declare(strict_types=1);

namespace Tests\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Builder\TypeBuilderFactory;
use CompositeGraphQL\Presentation\Value\ArgumentsSet;
use CompositeGraphQL\Presentation\Value\ArgumentType;
use CompositeGraphQL\Presentation\Value\Collections\Arguments;
use CompositeGraphQL\Presentation\Value\DefaultNames;
use CompositeGraphQL\Presentation\Value\InputRequired;
use CompositeGraphQL\Presentation\Value\OutputObject;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Tests\TestName;

final class ArgumentSetBuilderTest extends MockeryTestCase
{

    public function testBuild(): void
    {
        $factory = new TypeBuilderFactory();
        $schemaBuilder = new SchemaBuilder($factory);

        $name = new TestName('powerLevel');
        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('intensity'))
            ->type($schemaBuilder->float());

        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('duration'))
            ->type($schemaBuilder->int())
            ->required();
        $types = $schemaBuilder->build()->getTypes();
        $actual = $types->byName($name);
        $expected = new ArgumentsSet(
            new TestName('powerLevel'),
            new Arguments([
                new ArgumentType(
                    new TestName('intensity'),
                    $types->inputByName(DefaultNames::Float),
                ),
                new ArgumentType(
                    new TestName('duration'),
                    new InputRequired($types->inputByName(DefaultNames::Int)),
                ),
            ])
        );
        $this->assertEquals($expected, $actual);
    }


    public function testArgumentSetIsAddedToField(): void
    {
        $factory = new TypeBuilderFactory();
        $schemaBuilder = new SchemaBuilder($factory);

        $name = new TestName('powerLevel');
        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('intensity'))
            ->type($schemaBuilder->float());

        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('duration'))
            ->type($schemaBuilder->int())
            ->required();

        $objectName = new TestName('Human');

        $human = $schemaBuilder
            ->outputObject($objectName);

        $human
            ->field(new TestName('age'))
            ->type($schemaBuilder->int());

        $human
            ->field(new TestName('name'))
            ->type($schemaBuilder->string());

        $fieldName = new TestName('human');

        $schemaBuilder
            ->query()
            ->field($fieldName)
            ->type($schemaBuilder->outputObject($objectName))
            ->addArgumentSet($schemaBuilder->arguments($name));

        $types = $schemaBuilder->build()->getTypes();
        $type = $types->byName(DefaultNames::Query);
        assert($type instanceof OutputObject);

        $human = $type->getFields()->byName($fieldName);

        $actual = $human->getArguments();
        $expected = new Arguments([
            new ArgumentType(
                new TestName('intensity'),
                $types->inputByName(DefaultNames::Float),
            ),
            new ArgumentType(
                new TestName('duration'),
                new InputRequired($types->inputByName(DefaultNames::Int)),
            ),
        ]);

        $this->assertEquals($expected, $actual);
    }

    public function testArgumentSetIsAddedToFieldAfter(): void
    {
        $factory = new TypeBuilderFactory();
        $schemaBuilder = new SchemaBuilder($factory);

        $objectName = new TestName('Human');

        $human = $schemaBuilder
            ->outputObject($objectName);

        $human
            ->field(new TestName('age'))
            ->type($schemaBuilder->int());

        $human
            ->field(new TestName('name'))
            ->type($schemaBuilder->string());

        $fieldName = new TestName('human');

        $schemaBuilder
            ->query()
            ->field($fieldName)
            ->type($schemaBuilder->outputObject($objectName));



        $name = new TestName('powerLevel');
        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('intensity'))
            ->type($schemaBuilder->float());

        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('duration'))
            ->type($schemaBuilder->int())
            ->required();

        $schemaBuilder
            ->query()
            ->field($fieldName)
            ->addArgumentSet($schemaBuilder->arguments($name));

        $types = $schemaBuilder->build()->getTypes();
        $type = $types->byName(DefaultNames::Query);
        assert($type instanceof OutputObject);

        $human = $type->getFields()->byName($fieldName);

        $actual = $human->getArguments();
        $expected = new Arguments([
            new ArgumentType(
                new TestName('intensity'),
                $types->inputByName(DefaultNames::Float),
            ),
            new ArgumentType(
                new TestName('duration'),
                new InputRequired($types->inputByName(DefaultNames::Int)),
            ),
        ]);

        $this->assertEquals($expected, $actual);
    }


    public function testArgumentSetIsAddedToFieldSameFields(): void
    {
        $factory = new TypeBuilderFactory();
        $schemaBuilder = new SchemaBuilder($factory);

        $objectName = new TestName('Human');

        $human = $schemaBuilder
            ->outputObject($objectName);

        $human
            ->field(new TestName('age'))
            ->type($schemaBuilder->int());

        $human
            ->field(new TestName('name'))
            ->type($schemaBuilder->string());

        $fieldName = new TestName('human');

        $schemaBuilder
            ->query()
            ->field($fieldName)
            ->type($schemaBuilder->outputObject($objectName));

        $schemaBuilder
            ->query()
            ->field($fieldName)
            ->argument(new TestName('intensity'))
            ->required();

        $name = new TestName('powerLevel');
        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('intensity'))
            ->type($schemaBuilder->float());

        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('duration'))
            ->type($schemaBuilder->int())
            ->required();

        $schemaBuilder
            ->query()
            ->field($fieldName)
            ->addArgumentSet($schemaBuilder->arguments($name));

        $types = $schemaBuilder->build()->getTypes();
        $type = $types->byName(DefaultNames::Query);
        assert($type instanceof OutputObject);

        $human = $type->getFields()->byName($fieldName);

        $actual = $human->getArguments();
        $expected = new Arguments([
            new ArgumentType(
                new TestName('intensity'),
                new InputRequired($types->inputByName(DefaultNames::Float)),
            ),
            new ArgumentType(
                new TestName('duration'),
                new InputRequired($types->inputByName(DefaultNames::Int)),
            ),
        ]);

        $this->assertEquals($expected, $actual);
    }

}
