<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class;

use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\Argument;
use CompositeGraphQL\Presentation\Printer\Class\PHP\DTO\Member;
use CompositeGraphQL\Presentation\Value\OutputFieldType;
use CompositeGraphQL\Presentation\Value\OutputRequired;

final class OutputFieldTypeMapper
{
    public function __construct(
        private readonly TypeMapper $mapper
    ) {
    }

    function mapAsField(OutputFieldType $type): Member
    {
        $memberType = $type->getType();
        if ($memberType instanceof OutputRequired) {
            return new Member(
                $type->getName()->toString(),
                $this->mapper->map($memberType->of()),
                false
            );
        }
        return new Member(
            $type->getName()->toString(),
            $this->mapper->map($memberType),
            true,
            'null'
        );
    }

    public function mapAsArgument(OutputRequired|OutputFieldType $type): Argument
    {
        $memberType = $type->getType();
        if ($memberType instanceof OutputRequired) {
            return new Argument(
                $type->getName()->toString(),
                $this->mapper->map($memberType->of()),
                false
            );
        }
        return new Argument(
            $type->getName()->toString(),
            $this->mapper->map($memberType),
            true
        );
    }
}
