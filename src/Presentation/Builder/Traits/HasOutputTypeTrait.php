<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder\Traits;

use CompositeGraphQL\Presentation\Builder\SchemaBuilder;
use CompositeGraphQL\Presentation\Contract\OutputBuilder;
use CompositeGraphQL\Presentation\Value\OutputCollection;
use CompositeGraphQL\Presentation\Value\OutputRequired;
use CompositeGraphQL\Presentation\Value\OutputType;

trait HasOutputTypeTrait
{
    private ?OutputBuilder $outputType = null;

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

    public function type(OutputBuilder $nested): self
    {
        $this->root()->assertMutable();
        $this->outputType = $nested;

        return $this;
    }

    protected function buildType(): OutputType
    {
        if (!$this->outputType) {
            throw new \CompileError(sprintf('%s Should have outputType', $this));
        }
        $type = $this->outputType->buildOutput();
        if ($this->isRequired) {
            $type = new OutputRequired($type);
        }
        if ($this->isCollection) {
            $type = new OutputCollection($type);
            if ($this->isRequired) {
                $type = new OutputRequired($type);
            }
        }

        return $type;
    }

    public function outputTypeFromInterface(OutputBuilder|null $outputType): void
    {
        $this->root()->assertLocked();
        if ($this->outputType) {
            return;
        }
        $this->outputType = $outputType;
    }

    abstract public function root(): SchemaBuilder;

    abstract public function __toString(): string;
}
