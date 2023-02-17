<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value\Collections;

use CompositeGraphQL\Presentation\Value\OutputFieldType;
use CompositeGraphQL\Presentation\Value\Type;

/**
 * @extends AbstractCollection<OutputFieldType>
 */
class OutputFields extends AbstractCollection
{
    public function isValid(Type $normalized): bool
    {
        return $normalized instanceof OutputFieldType;
    }

    public function addInterfaceFields(Interfaces $interfaces): self
    {
        $copy = clone $this;
        foreach ($interfaces->getTypes() as $interface) {
            foreach ($interface->getFields()->getTypes() as $field) {
                if ($copy->has($field->getName())) {
                    continue;
                }
                $copy = $copy->add($field);
            }
        }

        return $copy;
    }
}
