<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class;

final class SchemaTextPrinterSingleton
{
    private static ?SchemaTextPrinter $instance = null;

    public static function getInstance(): SchemaTextPrinter
    {
        if (self::$instance === null) {
            self::$instance = new SchemaTextPrinter(TextPrinterSingleton::getInstance());
        }
        return self::$instance;
    }
}
