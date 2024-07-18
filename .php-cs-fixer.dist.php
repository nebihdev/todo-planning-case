<?php

$finder = PhpCsFixer\Finder::create()
->in(__DIR__.'/app')
->in(__DIR__.'/tests')
->in(__DIR__.'/database')
->in(__DIR__.'/config')
;

return (new PhpCsFixer\Config())
->setRules([
'@Symfony' => true,
'@PSR2' => true,
'array_syntax' => ['syntax' => 'short'],
'yoda_style' => false,
])
->setFinder($finder)
;