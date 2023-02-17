<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->exclude('var');


return (new PhpCsFixer\Config())
    ->setCacheFile('/app/var/.php-cs-fixer.cache')
    ->setRules(
        [
            // See the list of rules this rule set applies: https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/3.0/doc/ruleSets/Symfony.rst.
            '@Symfony' => true,
            'yoda_style' => false,
            'phpdoc_align' => false,
            'single_line_throw' => false,
            'concat_space' => [
                'spacing' => 'one',
            ],
            'trailing_comma_in_multiline' => [
                'elements' => [
                    'arrays',
                    'arguments',
                    'parameters',
                ],
            ],
        ]
    )
    ->setFinder($finder);
