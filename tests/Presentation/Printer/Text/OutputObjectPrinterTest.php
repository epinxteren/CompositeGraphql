<?php
declare(strict_types=1);

namespace Tests\Presentation\Printer\Text;

use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\Text\MemberTextPrinter;
use CompositeGraphQL\Presentation\Printer\Text\OutputObjectPrinter;
use CompositeGraphQL\Presentation\Printer\TypeNamePrinter;
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

final class OutputObjectPrinterTest extends MockeryTestCase
{

    /**
     * @dataProvider provideTestPrint
     *
     * @param OutputObject $object
     * @param string $expected
     * @return void
     */
    public function testPrint(OutputObject $object, string $expected): void
    {
        $next = new TypeNamePrinter();
        // Should not use the actual implementation, but it's a nice to see how it works in the end.
        $memberPrinter = new MemberTextPrinter($next);
        $indent = new IndentationPrinter();
        $printer = new OutputObjectPrinter($next, $memberPrinter, $indent);

        $options = PrinterOptions::default()->withIndentationSize(2);

        $this->assertEquals(
            $expected,
            $printer->print($object, $options)
        );
    }

    public function provideTestPrint(): array
    {
        return [
            'EmptyObject' => [
                new OutputObject(
                    new TestName('MyObject'),
                    new Arguments([]),
                    new OutputFields([]),
                    new Interfaces([])
                ),
                'OutputObject MyObject {}',
            ],
            'ObjectWithFields' => [
                new OutputObject(
                    new TestName('MyObject'),
                    new Arguments([]),
                    new OutputFields([
                        new OutputFieldType(
                            new TestName('myField'),
                            new ScalarType(DefaultNames::String),
                            new Arguments([])
                        ),
                    ]),
                    new Interfaces([])
                ),
                "OutputObject MyObject {\n  myField: String\n}",
            ],
            'ObjectWithFieldsAndArguments' => [
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
                    new Interfaces([])
                ),
                "OutputObject MyObject {\n  myField(myArgument: String): String\n}",
            ],
            'ObjectWithFieldsAndArgumentsAndInterfaces' => [
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
                'OutputObject MyObject implements MyInterface {
  myField(myArgument: String): String
}',
            ],
            'ObjectWithFieldsAndArgumentsAndInterfacesAndArguments' => [
                new OutputObject(
                    new TestName('MyObject'),
                    // TODO: Should this be removed?
                    new Arguments([
                        new ArgumentType(
                            new TestName('myArgument'),
                            new ScalarType(DefaultNames::String)
                        ),
                    ]),
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
                'OutputObject MyObject implements MyInterface {
  myField(myArgument: String): String
}',
            ],
            'Multiple fields ' => [
                new OutputObject(
                    new TestName('MyObject'),
                    new Arguments([]),
                    new OutputFields([
                        new OutputFieldType(
                            new TestName('myField'),
                            new ScalarType(DefaultNames::String),
                            new Arguments([])
                        ),
                        new OutputFieldType(
                            new TestName('myField2'),
                            new ScalarType(DefaultNames::String),
                            new Arguments([])
                        ),
                    ]),
                    new Interfaces([])
                ),
                'OutputObject MyObject {
  myField: String
  myField2: String
}',
            ],
            'Multiple fields with arguments' => [
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
                        new OutputFieldType(
                            new TestName('myField2'),
                            new ScalarType(DefaultNames::String),
                            new Arguments([
                                new ArgumentType(
                                    new TestName('myArgument'),
                                    new ScalarType(DefaultNames::String)
                                ),
                            ])
                        ),
                    ]),
                    new Interfaces([])
                ),
                'OutputObject MyObject {
  myField(myArgument: String): String
  myField2(myArgument: String): String
}',
            ],
            'Multiple fields with arguments and interfaces' => [
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
                        new OutputFieldType(
                            new TestName('myField2'),
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
                        new InterfaceType(
                            new TestName('MyInterface2'),
                            new OutputFields([])
                        ),
                    ])
                ),
                'OutputObject MyObject implements MyInterface, MyInterface2 {
  myField(myArgument: String): String
  myField2(myArgument: String): String
}',
            ],
        ];
    }
}
