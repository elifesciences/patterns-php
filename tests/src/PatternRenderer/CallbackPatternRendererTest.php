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
    public function it_renders_a_view_model()
    {
        $callback = function () {
            return 'foo';
        };
        $patternRenderer = new CallbackPatternRenderer($callback);

        $viewModel = $this->prophesize(ViewModel::class);
        $viewModel->offsetExists('foo')->willReturn(true);
        $viewModel->offsetGet('foo')->willReturn('bar');
        $viewModel->getTemplateName()->willReturn('foo {{foo}}');

        $this->assertSame('foo', $patternRenderer->render($viewModel->reveal()));
    }
}
