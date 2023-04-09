<?php
declare(strict_types=1);

namespace Tests\Presentation\Printer\Class\PHP;

use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\Abstraction;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\Argument;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\Arguments;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\ClassInstance;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\ClassNamespace;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\Constructor;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\Func;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\InterfaceInstance;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\Member;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\ValueType;
use CompositeGraphQL\Presentation\Printer\Class\PHP\Printer;
use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class PrinterTest extends MockeryTestCase
{
    public function testPrintEmptyClass(): void
    {
        $instance = new ClassInstance(new ClassNamespace('Example\MyClass'));
        $this->assert(
            $instance,
            '<?php
declare(strict_types=1);

namespace Example\MyClass;

class MyClass {

}'
        );
    }

    public function testPrintClassWithMembers(): void
    {
        $instance = new ClassInstance(new ClassNamespace('Example\MyClass'));
        $instance->members->members[] = new Member('foo', 'string');
        $instance->members->members[] = new Member('bar', 'int', true);
        $instance->members->members[] = new Member('time', new ClassNamespace(\DateTimeImmutable::class));
        $instance->members->members[] = new Member('enabled', 'bool', false, 'true');
        $this->assert(
            $instance,
            '<?php
declare(strict_types=1);

namespace Example\MyClass;

use DateTimeImmutable;

class MyClass {

  public string foo;
  public ?int bar;
  public DateTimeImmutable time;
  public bool enabled = true;

}'
        );
    }

    public function testPrintClassWithFunctions(): void
    {
        $instance = new ClassInstance(new ClassNamespace('Example\MyClass'));
        $instance->functions->functions[] = new Func(
            'foo', new Arguments(
            new Argument('bar', 'string'),
            new Argument('baz', 'int', true),
        ), '// do something'
        );
        $instance->functions->functions[] = new Func(
            'bar', new Arguments(
            new Argument('bar', 'string'),
            new Argument('baz1', 'string'),
            new Argument('baz2', 'string', false, '"hello"'),
            new Argument('baz3', 'string', true),
            new Argument('baz4', 'string'),
        ), '// do something', new ValueType('string')
        );

        $this->assert(
            $instance,
            '<?php
declare(strict_types=1);

namespace Example\MyClass;

class MyClass {

  public function foo(string bar, ?int baz): void {
    // do something
  }

  public function bar(
    string bar,
    string baz1,
    string baz2 = "hello",
    ?string baz3,
    string baz4): string {
    // do something
  }

}'
        );
    }

    public function testWithConstructor()
    {
        $instance = new ClassInstance(new ClassNamespace('Example\FooBar'));
        $instance->constructor = new Constructor(
            new Arguments(
                new Argument('bar', 'string'),
                new Argument('baz1', 'string'),
                new Argument('baz2', 'string', false, '"hello"'),
                new Argument('baz3', 'string', true),
                new Argument('baz4', 'string'),
            ), '// do something'
        );

        return $this->assert(
            $instance,
            '<?php
declare(strict_types=1);

namespace Example\FooBar;

class FooBar {

  public function __construct (
    public string bar,
    public string baz1,
    public string baz2 = "hello",
    public ?string baz3,
    public string baz4) {
    // do something
  }

}'
        );
    }


    public function testPrintInterface(): void
    {
        $instance = new InterfaceInstance(new ClassNamespace('Example\MyInterface'));

        $instance->interfaces->interfaces[] = new ClassNamespace('Example\HasSomething');

        $instance->functions->functions[] = new Func(
            'foo', new Arguments(
            new Argument('bar', 'string'),
            new Argument('baz', 'int', true),
        ), '// do something'
        );

        $instance->functions->functions[] = new Func(
            'bar', new Arguments(
            new Argument('bar', 'string'),
            new Argument('baz1', 'string'),
            new Argument('baz2', 'string', false, '"hello"'),
            new Argument('baz3', 'string', true),
            new Argument('baz4', 'string'),
        ), '// do something', new ValueType('string')
        );

        $this->assert(
            $instance,
            '<?php
declare(strict_types=1);

namespace Example\MyInterface;

interface MyInterface extends Example\HasSomething {

  public function foo(string bar, ?int baz): void;

  public function bar(
    string bar,
    string baz1,
    string baz2 = "hello",
    ?string baz3,
    string baz4): string;
}'
        );
    }


    private function assert(Abstraction $abstraction, string $expected): void
    {
        $indentationPrinter = new IndentationPrinter();
        $printer = new Printer($indentationPrinter);
        $actual = '';
        $options = PrinterOptions::default()->withIndentationSize(2);

        if ($abstraction instanceof ClassInstance) {
            $actual = $printer->printClass($abstraction, $options);
        }
        if ($abstraction instanceof InterfaceInstance) {
            $actual = $printer->printInterface($abstraction, $options);
        }
        $this->assertEquals($expected, $actual);
    }

}
