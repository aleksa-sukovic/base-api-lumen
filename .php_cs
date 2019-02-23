<?php

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2'                  => true,
        'array_syntax'           => ['syntax' => 'short'],
        'binary_operator_spaces' => [
            'operators' => [
                '=>' => 'align_single_space'
            ]
        ]
    ])
    ->setIndent("    ")
    ->setLineEnding("\n");
