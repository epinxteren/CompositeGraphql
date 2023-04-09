<?php
declare(strict_types=1);

namespace Tests\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Builder\TypeBuilderFactory;
use CompositeGraphQL\Presentation\Printer\Debug\PrinterSingleton;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
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

        $type = $schemaBuilder->build()->getTypes()->byName($name);
        $options = PrinterOptions::default();
        $result = PrinterSingleton::getInstance()->print(
            $type,
            $options
        );

        $this->assertEquals(
            'InputObject People {
  age: Int
  name: String!
  children: [Child!]!
  """
  The number of descendants
  """
  descendants: Float
}',
            $result
        );
    }
}
