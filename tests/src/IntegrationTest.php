<?php

namespace tests\eLife\Patterns;

use eLife\Patterns\Mustache\PatternLabLoader;
use eLife\Patterns\Mustache\PuliLoader;
use eLife\Patterns\PatternRenderer;
use eLife\Patterns\PatternRenderer\MustachePatternRenderer;
use eLife\Patterns\ViewModel;
use Mustache_Engine;
use PHPUnit_Framework_TestCase;
use Puli\Repository\FilesystemRepository;

final class IntegrationTest extends PHPUnit_Framework_TestCase
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
        $repo = new FilesystemRepository(__DIR__ . '/../resources');
        $puliLoader = new PuliLoader($repo);

        $patternLabLoader = new PatternLabLoader($repo->get('/')->getFilesystemPath());

        $mustache = new Mustache_Engine(['loader' => $puliLoader, 'partials_loader' => $patternLabLoader]);

        return new MustachePatternRenderer($mustache);
    }
}
