<?php

/**
 * PHP-CS-Fixer configuration file.
 *
 * @license MIT
 * @author KnosTx <nurazligaming@gmail.com>
 * @link https://github.com/KnosTx
 */

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__) // Specify the directory to search for PHP files.
    ->name('*.php') // Only consider PHP files.
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setFinder($finder)
    ->setRiskyAllowed(true) // Allow risky rules if necessary.
    ->setRules([
        'array_syntax' => ['syntax' => 'short'], // Use short array syntax.
        'binary_operator_spaces' => [
            'default' => 'single_space',
            'operators' => ['=>' => null],
        ],
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => [
            'statements' => ['return', 'throw', 'try'],
        ],
        'cast_spaces' => ['space' => 'single'],
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'one',
                'method' => 'one',
                'property' => 'one',
            ],
        ],
        'concat_space' => ['spacing' => 'one'],
        'declare_strict_types' => true, // Add `declare(strict_types=1)` if missing.
        'header_comment' => [ // Add a license header to each file.
            'header' => <<<EOT
This file is part of Boardify.

@license MIT
@author KnosTx <nurazligaming@gmail.com>
@link https://github.com/KnosTx
EOT,
            'location' => 'after_open', // Place the header after `declare(strict_types=1)`.
            'comment_type' => 'comment', // Use standard block comment.
        ],
        'line_ending' => true, // Ensure consistent line endings.
        'lowercase_keywords' => true,
        'lowercase_static_reference' => true,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'new_with_braces' => true,
        'no_trailing_whitespace' => true,
        'no_unused_imports' => true,
        'ordered_imports' => [
            'sort_algorithm' => 'alpha', // Alphabetical order for imports.
        ],
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_order' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_trim' => true,
        'single_blank_line_at_eof' => true,
        'single_quote' => true, // Use single quotes where possible.
        'strict_comparison' => true, // Use strict comparisons.
        'strict_param' => true, // Enforce strict parameter rules.
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'yoda_style' => false,
    ]);
