<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Converter;

use CompositeGraphQL\Presentation\Builder\InputFieldBuilder;
use CompositeGraphQL\Presentation\Builder\OutputFieldBuilder;
use CompositeGraphQL\Presentation\Converter\Value\ConverterOptions;
use CompositeGraphQL\Presentation\Converter\Value\ReflectionPropertyContext;

final class PropertyConverter
{
    public function convert(ConverterOptions $options, ReflectionPropertyContext $context): InputFieldBuilder|OutputFieldBuilder
    {
        $type = $context->property->getType();

        if ($type === null) {
            throw new \Exception('Property type is null');
        }
        $parent = $options->isInput() ? $context->builder->inputObject($context->class->name) : $context->builder->outputObject($context->class->name);
        $builder = $parent->field($context->name);

        if ($type instanceof \ReflectionNamedType) {
            $typeName = $type->getName();

            switch ($typeName) {
                case 'int':
                    $builder->type($builder->root()->int());
                    break;
                case 'string':
                    $builder->type($builder->root()->string());
                    break;
                case 'bool':
                    $builder->type($builder->root()->boolean());
                    break;
                case 'float':
                    $builder->type($builder->root()->float());
                    break;
                case 'array':
                    // Resolve array type



                    break;
                default:
                    throw new \Exception('Unknown type: ' . $typeName);
            }
        }

        if (!$type->allowsNull()) {
            $builder->required();
        }

        return $builder;
    }
}
