<?php

namespace eLife\Patterns\PatternRenderer;

use eLife\Patterns\PatternRenderer;
use eLife\Patterns\ViewModel;
use Mustache_Engine;

final class MustachePatternRenderer implements PatternRenderer
{
    private $mustache;

    public function __construct(Mustache_Engine $mustache)
    {
        $this->mustache = $mustache;
    }

    public function render(ViewModel $viewModel) : string
    {
        return $this->mustache->render($viewModel->getTemplateName(), $viewModel);
    }
}
