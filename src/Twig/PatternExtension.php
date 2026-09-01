<?php

namespace eLife\Patterns\Twig;

use eLife\Patterns\PatternRenderer;
use eLife\Patterns\ViewModel;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class PatternExtension extends AbstractExtension
{
    private $renderer;

    public function __construct(PatternRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'render_pattern',
                [$this, 'renderPattern'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    public function renderPattern(ViewModel $viewModel) : string
    {
        return $this->renderer->render($viewModel);
    }
}
