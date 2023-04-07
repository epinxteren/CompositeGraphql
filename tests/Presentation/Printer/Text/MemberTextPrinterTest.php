<?php
declare(strict_types=1);

namespace Tests\Presentation\Printer\Text;

use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\Text\MemberTextPrinter;
use CompositeGraphQL\Presentation\Printer\Text\TestPrinter;
use CompositeGraphQL\Presentation\Printer\TypeNamePrinter;
use CompositeGraphQL\Presentation\Value\ArgumentType;
use CompositeGraphQL\Presentation\Value\Collections\Arguments;
use CompositeGraphQL\Presentation\Value\Collections\InputFields;
use CompositeGraphQL\Presentation\Value\Collections\OutputFields;
use CompositeGraphQL\Presentation\Value\DefaultNames;
use CompositeGraphQL\Presentation\Value\InputFieldType;
use CompositeGraphQL\Presentation\Value\OutputFieldType;
use CompositeGraphQL\Presentation\Value\ScalarType;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Tests\TestName;

final class MemberTextPrinterTest extends MockeryTestCase
{
    public function testPrint(): void
    {
        $string = new ScalarType(DefaultNames::String);
        $int = new ScalarType(DefaultNames::Int);

        $next = new TypeNamePrinter();
        $memberTextPrinter = new MemberTextPrinter($next);

        $inputs = new InputFields([
            new InputFieldType(TestName::fromString('name'), $string),
            new InputFieldType(TestName::fromString('age'), $int),
        ]);

        $this->assertEquals(
            implode(PHP_EOL, [
                "name: String",
                "age: Int",
            ]),
            $memberTextPrinter->print($inputs, new PrinterOptions())
        );
    }

    public function testPrintWithOutputArguments(): void
    {
        $string = new ScalarType(DefaultNames::String);
        $int = new ScalarType(DefaultNames::Int);

        $next = new TypeNamePrinter();
        $memberTextPrinter = new MemberTextPrinter($next);

        $inputs = new OutputFields([
            new OutputFieldType(TestName::fromString('name'), $string, new Arguments([
                new ArgumentType(TestName::fromString('uppercase'), $string),
                new ArgumentType(TestName::fromString('bold'), $int),
            ])),
            new OutputFieldType(TestName::fromString('age'), $int, new Arguments([
                new ArgumentType(TestName::fromString('binary'), $string),
                new ArgumentType(TestName::fromString('octal'), $int),
            ])),
        ]);

        $this->assertEquals(
            implode(PHP_EOL, [
                "name(uppercase: String, bold: Int): String",
                "age(binary: String, octal: Int): Int",
            ]),
            $memberTextPrinter->print($inputs, new PrinterOptions())
        );
    }

    public function testPrintWithDescription(): void
    {
        $string = new ScalarType(DefaultNames::String);
        $int = new ScalarType(DefaultNames::Int);

        $next = new TypeNamePrinter();
        $memberTextPrinter = new MemberTextPrinter($next);

        $inputs = new InputFields([
            (new InputFieldType(TestName::fromString('name'), $string))->withDescription('The name'),
            (new InputFieldType(TestName::fromString('age'), $int))->withDescription('The age')
        ]);

        $this->assertEquals(
            implode(PHP_EOL, [
                '\\\\ The name',
                "name: String",
                '\\\\ The age',
                "age: Int",
            ]),
            $memberTextPrinter->print($inputs, new PrinterOptions())
        );
    }

}
