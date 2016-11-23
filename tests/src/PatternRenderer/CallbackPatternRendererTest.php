<?php

namespace tests\eLife\Patterns\PatternRenderer;

use eLife\Patterns\PatternRenderer;
use eLife\Patterns\PatternRenderer\CallbackPatternRenderer;
use eLife\Patterns\ViewModel;
use PHPUnit_Framework_TestCase;

final class CallbackPatternRendererTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_is_a_pattern_renderer()
    {
        $callback = function () {
            return 'foo';
        };
        $patternRenderer = new CallbackPatternRenderer($callback);

        $this->assertInstanceOf(PatternRenderer::class, $patternRenderer);
    }

    /**
     * @test
     */
    public function it_renders_view_models()
    {
        $callback = function () {
            return 'foo';
        };
        $patternRenderer = new CallbackPatternRenderer($callback);

        $viewModel1 = $this->prophesize(ViewModel::class);
        $viewModel1->offsetExists('foo')->willReturn(true);
        $viewModel1->offsetGet('foo')->willReturn('bar');
        $viewModel1->getTemplateName()->willReturn('foo {{foo}}');

        $viewModel2 = $this->prophesize(ViewModel::class);
        $viewModel2->offsetExists('baz')->willReturn(true);
        $viewModel2->offsetGet('baz')->willReturn('qux');
        $viewModel2->getTemplateName()->willReturn('baz {{baz}}');

        $this->assertSame('foo', $patternRenderer->render($viewModel1->reveal(), $viewModel2->reveal()));
    }
}
