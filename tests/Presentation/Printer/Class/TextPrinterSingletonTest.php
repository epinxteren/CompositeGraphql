<?php
declare(strict_types=1);

namespace Tests\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\Class\TextPrinterSingleton;
use CompositeGraphQL\Presentation\Value\ArgumentType;
use CompositeGraphQL\Presentation\Value\Collections\Arguments;
use CompositeGraphQL\Presentation\Value\Collections\Interfaces;
use CompositeGraphQL\Presentation\Value\Collections\OutputFields;
use CompositeGraphQL\Presentation\Value\DefaultNames;
use CompositeGraphQL\Presentation\Value\InterfaceType;
use CompositeGraphQL\Presentation\Value\OutputFieldType;
use CompositeGraphQL\Presentation\Value\OutputObject;
use CompositeGraphQL\Presentation\Value\ScalarType;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Tests\TestName;

final class TextPrinterSingletonTest extends MockeryTestCase
{

    public function testPrint(): void
    {
        $printer = TextPrinterSingleton::getInstance();
        $printed = $printer->print(
            new OutputObject(
                new TestName('MyObject'),
                new Arguments([]),
                new OutputFields([
                    new OutputFieldType(
                        new TestName('myField'),
                        new ScalarType(DefaultNames::String),
                        new Arguments([
                            new ArgumentType(
                                new TestName('myArgument'),
                                new ScalarType(DefaultNames::String)
                            ),
                        ])
                    ),
                ]),
                new Interfaces([
                    new InterfaceType(
                        new TestName('MyInterface'),
                        new OutputFields([])
                    ),
                ])
            ),
            new PrinterOptions()
        );
        $this->assertEquals(
            'OutputObject MyObject implements MyInterface {
  myField(myArgument: scalar String): scalar String
}',
            $printed
        );

    }
}
