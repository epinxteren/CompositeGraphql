<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Builder;

use CompositeGraphQL\Presentation\Builder\Traits\HasArgumentsTrait;
use CompositeGraphQL\Presentation\Builder\Traits\HasDescriptionTrait;
use CompositeGraphQL\Presentation\Builder\Traits\HasInterfaceTrait;
use CompositeGraphQL\Presentation\Builder\Traits\HasOutputFieldsTrait;
use CompositeGraphQL\Presentation\Contract\OutputObject as OutputObjectInterface;
use CompositeGraphQL\Presentation\Value\Name;
use CompositeGraphQL\Presentation\Value\OutputObject;
use CompositeGraphQL\Presentation\Value\OutputType;

class OutputObjectBuilder extends AbstractOutputBuilder implements OutputObjectInterface
{
    use HasDescriptionTrait;
    use HasOutputFieldsTrait;
    use HasArgumentsTrait;
    use HasInterfaceTrait;

    /**
     * Convention function for relay arguments.
     */
    public function relayConnectionField(Name $name, Name $node): OutputFieldBuilder
    {
        $builder = $this->root();
        $field = $this->field($name);
        $field
            ->type($builder->connection($name, $node))
            ->addArgumentSet($builder->connectionArguments())
            ->required();

        return $field;
    }

    public function buildCached(): OutputType
    {
        return (new OutputObject(
            $this->getName(),
            $this->buildArguments(),
            $this->buildFields(),
            $this->buildInterfaces(),
        ))->withDescription($this->getDescription());
    }
}
