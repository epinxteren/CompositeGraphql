<?php

namespace CompositeGraphQL\Infrastructure\Webonyx\Factory\Traits;

use CompositeGraphQL\Presentation\Value\Type;
use Symfony\Component\DependencyInjection\Reference;

trait GeneratedReferenceTrait
{
    /**
     * @var array<string, Type>
     */
    private array $references = [];

    public function createReference(Type $type): Reference
    {
        foreach ($this->references as $id => $reference) {
            if ($reference === $type) {
                return new Reference($id);
            }
        }
        $id = uniqid(sprintf('GraphQL%sType', $type->getName()->toString()), true);
        $this->references[$id] = $type;

        return new Reference($id);
    }
}
