<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Symfony;

use CompositeGraphQL\Presentation\TypeProvider;
use Symfony\Component\Finder\Finder;

class FileCompilerPassTypeProviderLoader
{
    /**
     * Can't use dependencies during compile time.
     */
    public function __construct(private string $projectDir)
    {
    }

    /**
     * @return TypeProvider[]
     */
    public function load(): array
    {
        $directory = sprintf('%s/src', $this->projectDir);
        $finder = new Finder();
        $compilerPasses = [];
        foreach ($finder->in($directory)->files()->name('*TypeProvider.php') as $file) {
            $path = $file->getRelativePath();
            $className = sprintf("%s\%s", str_replace('/', '\\', $path), $file->getFilenameWithoutExtension());
            if (is_a($className, TypeProvider::class, true) && $className !== TypeProvider::class) {
                $compilerPasses[] = new $className();
            }
        }

        return $compilerPasses;
    }
}
