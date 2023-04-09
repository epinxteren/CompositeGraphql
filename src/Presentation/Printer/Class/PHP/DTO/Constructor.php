<?php
declare(strict_types=1);

namespace CompositeGraphQL\Presentation\Printer\Class\PHP\DTO;

class Constructor implements HasNamespaces
{
    public function __construct(
        public Arguments $arguments,
        public ?string $body = null,
    ) {
    }

    public function implementationCode(PrinterContext $context): string
    {
        $arguments = $this->arguments->asPublicMembers($context);

        return sprintf(
            'public function __construct (%s) {
%s
}',
            $arguments,
            $this->body ? $context->indent($this->body) : ''
        );
    }

    public function getNamespaces(): array
    {
        return array_merge(
            $this->arguments->getNamespaces(),
        );
    }
}