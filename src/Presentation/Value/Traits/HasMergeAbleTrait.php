<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Value\Traits;

use CompositeGraphQL\Presentation\Value\InputRequired;
use CompositeGraphQL\Presentation\Value\Name;
use CompositeGraphQL\Presentation\Value\OutputRequired;
use CompositeGraphQL\Presentation\Value\Type;

trait HasMergeAbleTrait
{
    abstract public function getName(): Name;

    /**
     * Merges required decorator and gaurentees that the name is the same.
     *
     * @param Type $other
     * @param callable(self $other): self $merge
     * @return Type
     */
    public function mergeCommon(Type $other, callable $merge): Type
    {
        if ($this->getName()->toString() !== $other->getName()->toString()) {
            throw new \InvalidArgumentException('Cannot merge with other name');
        }
        if ($other instanceof InputRequired) {
            return new InputRequired($merge($other->of()));
        }
        if ($other instanceof OutputRequired) {
            return new OutputRequired($merge($other->of()));
        }
        if (!$other instanceof self) {
            throw new \InvalidArgumentException('Cannot merge with other type');
        }

        return $merge($other);
    }
}