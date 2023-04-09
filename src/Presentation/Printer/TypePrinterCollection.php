<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer;

use CompositeGraphQL\Presentation\Value\Type;

final class TypePrinterCollection implements TypePrinter
{
    /**
     * @param TypePrinter[] $printers
     */
    public function __construct(private array $printers = [])
    {
    }

    public function print(Type $type, PrinterOptions $options): string
    {
        foreach ($this->printers as $printer) {
            if ($printer->supports($type)) {
                return $printer->print($type, $options);
            }
        }

        throw new \RuntimeException(sprintf('No printer found for type %s', get_class($type)));
    }

    public function add(TypePrinter $printer): void
    {
        $this->printers[] = $printer;
    }

    function supports(Type $type): bool
    {
        return true;
    }
}
