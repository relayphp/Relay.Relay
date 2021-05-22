<?php

$finder = PhpCsFixer\Finder::create()->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config->setRules([
            'mb_str_functions' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
