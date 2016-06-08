<?php

namespace tests\eLife\Patterns\PatternRenderer;

use eLife\Patterns\PatternRenderer;
use eLife\Patterns\PatternRenderer\MustachePatternRenderer;
use eLife\Patterns\ViewModel;
use Mustache_Engine;
use PHPUnit_Framework_TestCase;

final class MustachePatternRendererTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_is_a_pattern_renderer()
    {
        $patternRenderer = new MustachePatternRenderer(new Mustache_Engine());

        $this->assertInstanceOf(PatternRenderer::class, $patternRenderer);
    }

    /**
     * @test
     */
    public function it_renders_a_view_model()
    {
        $patternRenderer = new MustachePatternRenderer(new Mustache_Engine());

        $viewModel = $this->prophesize(ViewModel::class);
        $viewModel->offsetExists('foo')->willReturn(true);
        $viewModel->offsetGet('foo')->willReturn('bar');
        $viewModel->getTemplateName()->willReturn('foo {{foo}}');

        $this->assertSame('foo bar', $patternRenderer->render($viewModel->reveal()));
    }
}
