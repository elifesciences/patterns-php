<?php

namespace tests\eLife\Patterns;

use eLife\Patterns\PatternRenderer;
use eLife\Patterns\PatternRenderer\MustachePatternRenderer;
use eLife\Patterns\ViewModel;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;
use PHPUnit\Framework\TestCase;

final class IntegrationTest extends TestCase
{
    /**
     * @test
     */
    public function it_renders_a_view_model()
    {
        $viewModel = $this->prophesize(ViewModel::class);
        $viewModel->offsetExists('foo')->willReturn(true);
        $viewModel->offsetGet('foo')->willReturn('bar');
        $viewModel->getTemplateName()->willReturn('/foo.mustache');

        $patternRenderer = $this->createPatternRenderer();

        $this->assertSame("foo bar\n", $patternRenderer->render($viewModel->reveal()));
    }

    /**
     * @test
     */
    public function it_renders_a_view_model_with_a_partial()
    {
        $viewModel = $this->prophesize(ViewModel::class);
        $viewModel->offsetExists('foo')->willReturn(true);
        $viewModel->offsetGet('foo')->willReturn('bar');
        $viewModel->getTemplateName()->willReturn('/bar.mustache');

        $patternRenderer = $this->createPatternRenderer();

        $this->assertSame("foo bar\nbar\n", $patternRenderer->render($viewModel->reveal()));
    }

    private function createPatternRenderer() : PatternRenderer
    {
        $mustache = new Mustache_Engine([
            'loader' => new Mustache_Loader_FilesystemLoader(__DIR__.'/../resources'),
        ]);

        return new MustachePatternRenderer($mustache);
    }
}
