<?php

$finder = PhpCsFixer\Finder::create()->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setRules(
        [
            'mb_str_functions' => true,
        ]
    )
    ->setRiskyAllowed(true)
    ->setFinder($finder);
