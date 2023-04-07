<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Text;

use CompositeGraphQL\Presentation\Printer\IndentationPrinter;
use CompositeGraphQL\Presentation\Printer\TypePrinter;

/**
 * Used for debugging purposes.
 */
final class TextPrinterSingleton
{
    private static ?TypePrinter $instance = null;

    public static function getInstance(): TypePrinter
    {
        if (self::$instance === null) {
            $factory = new TextPrinterFactory(new IndentationPrinter());
            self::$instance = $factory->create();
        }
        return self::$instance;
    }

}