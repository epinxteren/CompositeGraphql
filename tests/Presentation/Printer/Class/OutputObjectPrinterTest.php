<?php
declare(strict_types=1);

namespace Tests\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\Class\NameToNamespaceConverter;
use CompositeGraphQL\Presentation\Printer\Class\OutputFieldTypeMapper;
use CompositeGraphQL\Presentation\Printer\Class\OutputObjectPrinter;
use CompositeGraphQL\Presentation\Printer\Class\PHP\Printer;
use CompositeGraphQL\Presentation\Printer\Class\TypeMapper;
use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Value\Collections\OutputFields;
use CompositeGraphQL\Presentation\Value\DefaultNames;
use CompositeGraphQL\Presentation\Value\OutputCollection;
use CompositeGraphQL\Presentation\Value\OutputFieldType;
use CompositeGraphQL\Presentation\Value\OutputObject;
use CompositeGraphQL\Presentation\Value\OutputRequired;
use CompositeGraphQL\Presentation\Value\ScalarType;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Tests\TestName;

final class OutputObjectPrinterTest extends MockeryTestCase
{

    public function testPrinting(): void
    {
        $indentationPrinter = new IndentationPrinter();
        $printer = new Printer($indentationPrinter);
        $namespaceConverter = new NameToNamespaceConverter();
        $typeMapper = new TypeMapper($namespaceConverter);
        $outputFieldTypeMapper = new OutputFieldTypeMapper($typeMapper);
        $objectPrinter = new OutputObjectPrinter(
            $printer,
            $namespaceConverter,
            $outputFieldTypeMapper,
        );
        $child = new OutputObject(
            new TestName('Child'),
            new OutputFields([
                new OutputFieldType(
                    new TestName('age'),
                    new ScalarType(DefaultNames::Int),
                ),
                new OutputFieldType(
                    new TestName('name'),
                    new OutputRequired(new ScalarType(DefaultNames::String)),
                ),
            ])
        );
        $objectToPrint = new OutputObject(
            new TestName('People'),
            new OutputFields([
                new OutputFieldType(
                    new TestName('age'),
                    new ScalarType(DefaultNames::Int),
                ),
                new OutputFieldType(
                    new TestName('name'),
                    new OutputRequired(new ScalarType(DefaultNames::String)),
                ),
                new OutputFieldType(
                    new TestName('children'),
                    new OutputRequired(
                        new OutputCollection(
                            new OutputRequired($child)
                        )
                    ),
                ),
                (new OutputFieldType(
                    new TestName('descendants'),
                    new ScalarType(DefaultNames::Float),
                ))->withDescription('The number of descendants'),
            ])
        );


        $class = $objectPrinter->print($objectToPrint, PrinterOptions::default());

        $this->assertEquals(
            '<?php
declare(strict_types=1);

namespace Example\People;

class People {

  public ?int age = null;
  public ?float descendants = null;

  public function __construct (public string name, public ChildCollection children) {

  }

}',
            $class
        );

    }
}
