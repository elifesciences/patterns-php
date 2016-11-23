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
    public function it_renders_view_models()
    {
        $patternRenderer = new MustachePatternRenderer(new Mustache_Engine());

        $viewModel1 = $this->prophesize(ViewModel::class);
        $viewModel1->offsetExists('foo')->willReturn(true);
        $viewModel1->offsetGet('foo')->willReturn('bar');
        $viewModel1->getTemplateName()->willReturn('foo {{foo}}');

        $viewModel2 = $this->prophesize(ViewModel::class);
        $viewModel2->offsetExists('baz')->willReturn(true);
        $viewModel2->offsetGet('baz')->willReturn('qux');
        $viewModel2->getTemplateName()->willReturn('baz {{baz}}');

        $this->assertSame('foo barbaz qux', $patternRenderer->render($viewModel1->reveal(), $viewModel2->reveal()));
    }
}
