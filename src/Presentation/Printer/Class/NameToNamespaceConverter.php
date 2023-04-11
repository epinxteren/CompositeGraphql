<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\ClassNamespace;
use CompositeGraphQL\Presentation\Value\Name;

final class NameToNamespaceConverter
{
    public function namespaceOf(Name $name): ClassNamespace
    {
        return new ClassNamespace('Example\\' . $name->toString(), null);
    }
}