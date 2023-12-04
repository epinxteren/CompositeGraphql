<?php

declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Converter;

use CompositeGraphQL\Presentation\Contract\OutputObject;
use CompositeGraphQL\Presentation\Converter\Value\ConverterOptions;
use CompositeGraphQL\Presentation\Converter\Value\ReflectionClassContext;

final class OutputClassConverter
{

    public function __construct(
        private PropertyConverter $propertyConverter,
        private TypeContainer     $container
    )
    {
    }

    public function convert(ConverterOptions $options, ReflectionClassContext $context): OutputObject
    {
        $resolved = $this->container->resolveOutputType($context->class->name);
        if ($resolved) {
            return $resolved;
        }
        $builder = $context->builder->outputObject($context->name);
        $this->container->registerOutputType($context->class->name, $builder);
        foreach ($context->class->getProperties() as $property) {
            $propertyContext = $context->property($property);
            $this->propertyConverter->convert($options, $propertyContext);
        }
        return $builder;
    }
}
