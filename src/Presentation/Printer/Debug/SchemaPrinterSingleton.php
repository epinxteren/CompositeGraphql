<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Debug;

use CompositeGraphQL\Presentation\Printer\IndentationPrinter;

final class SchemaPrinterSingleton
{
    private static ?SchemaPrinter $instance = null;

    public static function getInstance(): SchemaPrinter
    {
        if (self::$instance === null) {
            self::$instance = new SchemaPrinter(
                PrinterSingleton::getInstance(),
                new IndentationPrinter()
            );
        }

        return self::$instance;
    }
}
