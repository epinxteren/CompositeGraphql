<?php
declare(strict_types=1);

namespace Tests\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\Class\RequiredTypePrinter;
use CompositeGraphQL\Presentation\Printer\TypeNamePrinter;
use CompositeGraphQL\Presentation\Value\DefaultNames;
use CompositeGraphQL\Presentation\Value\InputRequired;
use CompositeGraphQL\Presentation\Value\ScalarType;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class RequiredTypePrinterTest extends MockeryTestCase
{

    public function testPrintNoneRequired(): void
    {

        $next = new TypeNamePrinter();
        $printer = new RequiredTypePrinter($next);

        $this->assertEquals(
            'String',
            $printer->print(
                new ScalarType(DefaultNames::String),
                new PrinterOptions()
            )
        );

    }

    public function testPrintRequired(): void
    {

        $next = new TypeNamePrinter();
        $printer = new RequiredTypePrinter($next);

        $this->assertEquals(
            'String!',
            $printer->print(
                new InputRequired(new ScalarType(DefaultNames::String)),
                new PrinterOptions()
            )
        );

    }
}
