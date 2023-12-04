<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Converter;

use CompositeGraphQL\Presentation\Contract\InputBuilder;
use CompositeGraphQL\Presentation\Converter\Value\ConverterOptions;
use CompositeGraphQL\Presentation\Converter\Value\ReflectionClassContext;

final class InputClassConverter
{

    public function __construct(
        private PropertyConverter $propertyConverter,
        private TypeContainer     $container
    )
    {
    }

    public function convert(ConverterOptions $options, ReflectionClassContext $context): InputBuilder
    {
        $resolved = $this->container->resolveInputType($context->class->name);
        if ($resolved) {
            return $resolved;
        }
        $builder = $context->builder->inputObject($context->name);
        $this->container->registerInputType($context->class->name, $builder);
        foreach ($context->class->getProperties() as $property) {
            $propertyContext = $context->property($property);
            $this->propertyConverter->convert($options, $propertyContext);
        }
        return $builder;
    }
}
