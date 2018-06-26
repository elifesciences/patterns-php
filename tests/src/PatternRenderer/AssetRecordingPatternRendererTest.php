<?php

namespace tests\eLife\Patterns\PatternRenderer;

use ArrayObject;
use eLife\Patterns\PatternRenderer;
use eLife\Patterns\PatternRenderer\AssetRecordingPatternRenderer;
use eLife\Patterns\ViewModel;
use PHPUnit_Framework_TestCase;

final class AssetRecordingPatternRendererTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_is_a_pattern_renderer()
    {
        $basePatternRenderer = $this->prophesize(PatternRenderer::class);
        $patternRenderer = new AssetRecordingPatternRenderer($basePatternRenderer->reveal());

        $this->assertInstanceOf(PatternRenderer::class, $patternRenderer);
    }

    /**
     * @test
     */
    public function it_renders_view_models()
    {
        $basePatternRenderer = $this->prophesize(PatternRenderer::class);
        $patternRenderer = new AssetRecordingPatternRenderer($basePatternRenderer->reveal());

        $viewModel1 = $this->prophesize(ViewModel::class);
        $viewModel1->getJavaScripts()->willReturn(new ArrayObject());
        $viewModel2 = $this->prophesize(ViewModel::class);
        $viewModel2->getJavaScripts()->willReturn(new ArrayObject());
        $basePatternRenderer->render($viewModel1, $viewModel2)->willReturn('foo');

        $this->assertSame('foo', $patternRenderer->render($viewModel1->reveal(), $viewModel2->reveal()));
    }

    /**
     * @test
     */
    public function it_records_unique_javascript()
    {
        $basePatternRenderer = $this->prophesize(PatternRenderer::class);
        $patternRenderer = new AssetRecordingPatternRenderer($basePatternRenderer->reveal());

        $viewModel1 = $this->prophesize(ViewModel::class);
        $viewModel1->getJavaScripts()->willReturn(new ArrayObject(['foo']));
        $viewModel2 = $this->prophesize(ViewModel::class);
        $viewModel2->getJavaScripts()->willReturn(new ArrayObject(['foo']));
        $basePatternRenderer->render($viewModel1, $viewModel2)->willReturn('foo');
        $viewModel3 = $this->prophesize(ViewModel::class);
        $viewModel3->getJavaScripts()->willReturn(new ArrayObject(['bar']));
        $basePatternRenderer->render($viewModel3)->willReturn('foo');

        $patternRenderer->render($viewModel1->reveal(), $viewModel2->reveal());
        $patternRenderer->render($viewModel3->reveal());

        $this->assertEquals(new ArrayObject(['foo', 'bar']), $patternRenderer->getJavaScripts());
    }
}
