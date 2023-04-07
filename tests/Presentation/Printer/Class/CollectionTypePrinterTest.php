<?php
declare(strict_types=1);

namespace Tests\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\Class\CollectionTypePrinter;
use CompositeGraphQL\Presentation\Printer\TypeNamePrinter;
use CompositeGraphQL\Presentation\Printer\TypePrinter;
use CompositeGraphQL\Presentation\Value\CollectionType;
use CompositeGraphQL\Presentation\Value\DefaultNames;
use CompositeGraphQL\Presentation\Value\InputCollection;
use CompositeGraphQL\Presentation\Value\OutputCollection;
use CompositeGraphQL\Presentation\Value\ScalarType;
use CompositeGraphQL\Presentation\Value\Type;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class CollectionTypePrinterTest extends MockeryTestCase
{

    /**
     * @dataProvider provideTestPrint
     *
     * @param CollectionType $toPrint
     * @return void
     */
    public function testPrint(Type $toPrint, string $expect): void
    {
        $next = new TypeNamePrinter();
        /** @var TypePrinter $next */
        $collectionTypePrinter = new CollectionTypePrinter($next);
        $result = $collectionTypePrinter->print(
            $toPrint,
            new PrinterOptions()
        );
        $this->assertEquals($expect, $result);
    }

    public function provideTestPrint(): array
    {
        return [
            'SingleInputValue' => [
                new ScalarType(
                    DefaultNames::String
                ),
                'String',
            ],
            'SingleOutputValue' => [
                new ScalarType(
                    DefaultNames::String
                ),
                'String',
            ],
            'MultipleInputValues' => [
                new InputCollection(
                    new ScalarType(
                        DefaultNames::String
                    )
                ),
                '[String]',
            ],
            'MultipleOutputValues' => [
                new OutputCollection(
                    new ScalarType(
                        DefaultNames::String
                    )
                ),
                '[String]',
            ],
        ];
    }
}
