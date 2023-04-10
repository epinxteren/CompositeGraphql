<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder\Traits;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Contract\InputBuilder;
use CompositeGraphQL\Presentation\Value\InputCollection;
use CompositeGraphQL\Presentation\Value\InputRequired;
use CompositeGraphQL\Presentation\Value\InputType;
use CompositeGraphQL\Presentation\Value\UndefinedType;

trait HasInputTypeTrait
{
    private ?InputBuilder $inputType = null;

    private bool $isRequired = false;
    private bool $isCollection = false;

    public function required(): self
    {
        $this->root()->assertMutable();
        $this->isRequired = true;

        return $this;
    }

    public function asCollection(): self
    {
        $this->root()->assertMutable();
        $this->isCollection = true;

        return $this;
    }

    public function type(InputBuilder $nested): self
    {
        $this->root()->assertMutable();

        if ($this->inputType !== null && $this->inputType->getName()->toString() !== $nested->getName()->toString()) {
            throw new \CompileError(sprintf('%s Should have only one inputType', $this));
        }

        $this->inputType = $nested;

        return $this;
    }

    protected function buildType(): InputType
    {
        $type = !$this->inputType ? new UndefinedType($this->getName()) : $this->inputType->buildInput();
        if ($this->isRequired) {
            $type = new InputRequired($type);
        }
        if ($this->isCollection) {
            $type = new InputCollection($type);
            if ($this->isRequired) {
                $type = new InputRequired($type);
            }
        }
        return $type;
    }

    abstract public function root(): SchemaBuilder;

    abstract public function __toString(): string;
}
