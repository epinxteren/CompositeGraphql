<?php
declare(strict_types=1);

namespace Tests\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Builder\TypeBuilderFactory;
use CompositeGraphQL\Presentation\Printer\Debug\PrinterSingleton;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Value\DefaultNames;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Tests\TestName;

final class ArgumentSetBuilderTest extends MockeryTestCase
{

    public function testBuild(): void
    {
        $factory = new TypeBuilderFactory();
        $schemaBuilder = new SchemaBuilder($factory);

        $name = new TestName('test');
        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('foo'))
            ->type($schemaBuilder->string());

        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('bar'))
            ->type($schemaBuilder->string())
            ->required();

        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('foobar'))
            ->type($schemaBuilder->string())
            ->required()
            ->asCollection();

        $type = $schemaBuilder->build()->getTypes()->byName($name);
        $options = PrinterOptions::default();
        $result = PrinterSingleton::getInstance()->print(
            $type,
            $options
        );

        $this->assertEquals(
            'ArgumentsSet test {
  foo: String;
  bar: String!;
  foobar: [String!]!;
}',
            $result
        );
    }


    public function testArgumentSetIsAddedToField(): void
    {
        $this->markTestIncomplete('Not yet implemented, arguments are not added to fields yet.');

        $factory = new TypeBuilderFactory();
        $schemaBuilder = new SchemaBuilder($factory);

        $name = new TestName('powerLevel');
        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('intensity'))
            ->type($schemaBuilder->string());

        $schemaBuilder
            ->arguments($name)
            ->argument(new TestName('duration'))
            ->type($schemaBuilder->string())
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

        $options = PrinterOptions::default();
        $type = $schemaBuilder->build()->getTypes()->byName(DefaultNames::Query);
        $result = PrinterSingleton::getInstance()->print(
            $type,
            $options
        );

        $this->assertEquals(
            'OutputObject Query {
  human: Human
}',
            $result
        );
    }

}
