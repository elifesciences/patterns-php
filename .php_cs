<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude('pattern-library')
;

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->finder($finder)
;
