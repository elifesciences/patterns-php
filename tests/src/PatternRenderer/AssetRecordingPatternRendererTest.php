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
    public function it_renders_a_view_model()
    {
        $basePatternRenderer = $this->prophesize(PatternRenderer::class);
        $patternRenderer = new AssetRecordingPatternRenderer($basePatternRenderer->reveal());

        $viewModel = $this->prophesize(ViewModel::class);
        $viewModel->getStyleSheets()->willReturn(new ArrayObject());
        $viewModel->getInlineStyleSheets()->willReturn(new ArrayObject());
        $viewModel->getJavaScripts()->willReturn(new ArrayObject());
        $viewModel->getInlineJavaScripts()->willReturn(new ArrayObject());
        $basePatternRenderer->render($viewModel)->willReturn('foo');

        $this->assertSame('foo', $patternRenderer->render($viewModel->reveal()));
    }

    /**
     * @test
     */
    public function it_records_unique_stylesheets()
    {
        $basePatternRenderer = $this->prophesize(PatternRenderer::class);
        $patternRenderer = new AssetRecordingPatternRenderer($basePatternRenderer->reveal());

        $viewModel1 = $this->prophesize(ViewModel::class);
        $viewModel1->getStyleSheets()->willReturn(new ArrayObject(['foo']));
        $viewModel1->getInlineStyleSheets()->willReturn(new ArrayObject());
        $viewModel1->getJavaScripts()->willReturn(new ArrayObject());
        $viewModel1->getInlineJavaScripts()->willReturn(new ArrayObject());
        $basePatternRenderer->render($viewModel1)->willReturn('foo');
        $viewModel2 = $this->prophesize(ViewModel::class);
        $viewModel2->getStyleSheets()->willReturn(new ArrayObject(['foo']));
        $viewModel2->getInlineStyleSheets()->willReturn(new ArrayObject());
        $viewModel2->getJavaScripts()->willReturn(new ArrayObject());
        $viewModel2->getInlineJavaScripts()->willReturn(new ArrayObject());
        $basePatternRenderer->render($viewModel2)->willReturn('foo');
        $viewModel3 = $this->prophesize(ViewModel::class);
        $viewModel3->getStyleSheets()->willReturn(new ArrayObject(['bar']));
        $viewModel3->getInlineStyleSheets()->willReturn(new ArrayObject());
        $viewModel3->getJavaScripts()->willReturn(new ArrayObject());
        $viewModel3->getInlineJavaScripts()->willReturn(new ArrayObject());
        $basePatternRenderer->render($viewModel3)->willReturn('foo');

        $patternRenderer->render($viewModel1->reveal());
        $patternRenderer->render($viewModel2->reveal());
        $patternRenderer->render($viewModel3->reveal());

        $this->assertEquals(new ArrayObject(['foo', 'bar']), $patternRenderer->getStyleSheets());
    }

    /**
     * @test
     */
    public function it_records_inline_stylesheets()
    {
        $basePatternRenderer = $this->prophesize(PatternRenderer::class);
        $patternRenderer = new AssetRecordingPatternRenderer($basePatternRenderer->reveal());

        $viewModel1 = $this->prophesize(ViewModel::class);
        $viewModel1->getStyleSheets()->willReturn(new ArrayObject());
        $viewModel1->getInlineStyleSheets()->willReturn(new ArrayObject(['foo']));
        $viewModel1->getJavaScripts()->willReturn(new ArrayObject());
        $viewModel1->getInlineJavaScripts()->willReturn(new ArrayObject());
        $basePatternRenderer->render($viewModel1)->willReturn('foo');
        $viewModel2 = $this->prophesize(ViewModel::class);
        $viewModel2->getStyleSheets()->willReturn(new ArrayObject());
        $viewModel2->getInlineStyleSheets()->willReturn(new ArrayObject(['foo']));
        $viewModel2->getJavaScripts()->willReturn(new ArrayObject());
        $viewModel2->getInlineJavaScripts()->willReturn(new ArrayObject());
        $basePatternRenderer->render($viewModel2)->willReturn('foo');
        $viewModel3 = $this->prophesize(ViewModel::class);
        $viewModel3->getStyleSheets()->willReturn(new ArrayObject());
        $viewModel3->getInlineStyleSheets()->willReturn(new ArrayObject(['bar']));
        $viewModel3->getJavaScripts()->willReturn(new ArrayObject());
        $viewModel3->getInlineJavaScripts()->willReturn(new ArrayObject());
        $basePatternRenderer->render($viewModel3)->willReturn('foo');

        $patternRenderer->render($viewModel1->reveal());
        $patternRenderer->render($viewModel2->reveal());
        $patternRenderer->render($viewModel3->reveal());

        $this->assertEquals(new ArrayObject(['foo', 'foo', 'bar']), $patternRenderer->getInlineStyleSheets());
    }

    /**
     * @test
     */
    public function it_records_unique_javascript()
    {
        $basePatternRenderer = $this->prophesize(PatternRenderer::class);
        $patternRenderer = new AssetRecordingPatternRenderer($basePatternRenderer->reveal());

        $viewModel1 = $this->prophesize(ViewModel::class);
        $viewModel1->getStyleSheets()->willReturn(new ArrayObject());
        $viewModel1->getInlineStyleSheets()->willReturn(new ArrayObject());
        $viewModel1->getJavaScripts()->willReturn(new ArrayObject(['foo']));
        $viewModel1->getInlineJavaScripts()->willReturn(new ArrayObject());
        $basePatternRenderer->render($viewModel1)->willReturn('foo');
        $viewModel2 = $this->prophesize(ViewModel::class);
        $viewModel2->getStyleSheets()->willReturn(new ArrayObject());
        $viewModel2->getInlineStyleSheets()->willReturn(new ArrayObject());
        $viewModel2->getJavaScripts()->willReturn(new ArrayObject(['foo']));
        $viewModel2->getInlineJavaScripts()->willReturn(new ArrayObject());
        $basePatternRenderer->render($viewModel2)->willReturn('foo');
        $viewModel3 = $this->prophesize(ViewModel::class);
        $viewModel3->getStyleSheets()->willReturn(new ArrayObject());
        $viewModel3->getInlineStyleSheets()->willReturn(new ArrayObject());
        $viewModel3->getJavaScripts()->willReturn(new ArrayObject(['bar']));
        $viewModel3->getInlineJavaScripts()->willReturn(new ArrayObject());
        $basePatternRenderer->render($viewModel3)->willReturn('foo');

        $patternRenderer->render($viewModel1->reveal());
        $patternRenderer->render($viewModel2->reveal());
        $patternRenderer->render($viewModel3->reveal());

        $this->assertEquals(new ArrayObject(['foo', 'bar']), $patternRenderer->getJavaScripts());
    }

    /**
     * @test
     */
    public function it_records_inline_javascript()
    {
        $basePatternRenderer = $this->prophesize(PatternRenderer::class);
        $patternRenderer = new AssetRecordingPatternRenderer($basePatternRenderer->reveal());

        $viewModel1 = $this->prophesize(ViewModel::class);
        $viewModel1->getStyleSheets()->willReturn(new ArrayObject());
        $viewModel1->getInlineStyleSheets()->willReturn(new ArrayObject());
        $viewModel1->getJavaScripts()->willReturn(new ArrayObject());
        $viewModel1->getInlineJavaScripts()->willReturn(new ArrayObject(['foo']));
        $basePatternRenderer->render($viewModel1)->willReturn('foo');
        $viewModel2 = $this->prophesize(ViewModel::class);
        $viewModel2->getStyleSheets()->willReturn(new ArrayObject());
        $viewModel2->getInlineStyleSheets()->willReturn(new ArrayObject());
        $viewModel2->getJavaScripts()->willReturn(new ArrayObject());
        $viewModel2->getInlineJavaScripts()->willReturn(new ArrayObject(['foo']));
        $basePatternRenderer->render($viewModel2)->willReturn('foo');
        $viewModel3 = $this->prophesize(ViewModel::class);
        $viewModel3->getStyleSheets()->willReturn(new ArrayObject());
        $viewModel3->getInlineStyleSheets()->willReturn(new ArrayObject());
        $viewModel3->getJavaScripts()->willReturn(new ArrayObject());
        $viewModel3->getInlineJavaScripts()->willReturn(new ArrayObject(['bar']));
        $basePatternRenderer->render($viewModel3)->willReturn('foo');

        $patternRenderer->render($viewModel1->reveal());
        $patternRenderer->render($viewModel2->reveal());
        $patternRenderer->render($viewModel3->reveal());

        $this->assertEquals(new ArrayObject(['foo', 'foo', 'bar']), $patternRenderer->getInlineJavaScripts());
    }
}
