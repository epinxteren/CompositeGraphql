<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP;

use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\ClassInstance;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\ClassNamespace;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\InterfaceInstance;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\PrinterContext;
use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\PrinterOptions;
use CompositeGraphQL\Presentation\Printer\SimpleTextPrinter;

final class Printer
{
    public function __construct(
        private IndentationPrinter $indentationPrinter,
    ) {
    }

    public function printClass(ClassInstance $instance, PrinterOptions $options): string
    {
        $context = new PrinterContext($this->indentationPrinter, $options);
        $printer = $this->createPHPPrinter($instance->namespace, $context);

        $namespaces = $instance->namespaces()->useStatementsAsCode($context);
        if ($namespaces) {
            $printer->lines(
                $namespaces,
                ''
            );
        }
        $printer->lines('class '.$instance->namespace->shortName());

        if ($instance->extends) {
            $printer->append(' extends '.$instance->extends->toCode($context));
        }

        if (!$instance->interfaces->empty()) {
            $printer->append(' implements '.$instance->interfaces->toCode($context));
        }

        $printer->append(' {');

        if ($instance->members->members) {
            $printer->lines(
                '',
                $this->indentationPrinter->indent($instance->members->toCode($context), $options),
            );
        }

        if ($instance->constructor) {
            $printer->lines(
                '',
                $this->indentationPrinter->indent($instance->constructor->implementationCode($context), $options),
            );
        }

        if ($instance->functions->functions) {
            $printer->lines(
                '',
                $this->indentationPrinter->indent($instance->functions->implementationCode($context), $options),
            );
        }

        $printer->lines('', '}');

        return $printer->toString();
    }

    public function printInterface(InterfaceInstance $instance, PrinterOptions $options): string
    {
        $context = new PrinterContext($this->indentationPrinter, $options);
        $printer = $this->createPHPPrinter($instance->namespace, $context);

        $namespaces = $instance->namespaces()->useStatementsAsCode($context);
        if ($namespaces) {
            $printer->lines(
                $namespaces,
                ''
            );
        }

        $printer->lines('interface '.$instance->namespace->shortName());

        if (!$instance->interfaces->empty()) {
            $printer->append(' extends '.$instance->interfaces->toCode($context));
        }

        $printer->append(' {');

        if ($instance->functions->functions) {
            $printer->lines(
                '',
                $this->indentationPrinter->indent($instance->functions->contractCode($context), $options),
            );
        }

        $printer->lines('}');

        return $printer->toString();
    }

    /**
     * @return SimpleTextPrinter
     */
    protected function createPHPPrinter(ClassNamespace $namespace, PrinterContext $context): SimpleTextPrinter
    {
        return new SimpleTextPrinter(
            '<?php',
            'declare(strict_types=1);',
            '',
            'namespace '.$namespace->toCode($context).';',
            ''
        );
    }
}