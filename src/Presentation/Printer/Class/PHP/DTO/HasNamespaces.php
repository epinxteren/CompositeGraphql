<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

interface HasNamespaces
{
    /**
     * @return array<ClassNamespace>
     */
    public function getNamespaces(): array;
}