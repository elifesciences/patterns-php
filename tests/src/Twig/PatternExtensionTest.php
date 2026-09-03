<?php

namespace tests\eLife\Patterns\Twig;

use eLife\Patterns\PatternRenderer\CallbackPatternRenderer;
use eLife\Patterns\Twig\PatternExtension;
use eLife\Patterns\ViewModel;
use eLife\Patterns\ViewModel\FlexibleViewModel;
use PHPUnit\Framework\TestCase;
use Twig\Loader\ArrayLoader;
use Twig\Extension\AbstractExtension;
use Twig\Environment;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Depends;

final class PatternExtensionTest extends TestCase
{
    #[Test]
    public function it_is_a_twig_extension()
    {
        $extension = new PatternExtension(new CallbackPatternRenderer(function (ViewModel $viewModel) : string {
            return 'foobar';
        }));

        $this->assertInstanceOf(AbstractExtension::class, $extension);
    }

    #[Test]
    #[Depends('it_is_a_twig_extension')]
    public function it_renders_patterns()
    {
        $twigLoader = new ArrayLoader(['foo' => '{{render_pattern(bar)}}']);
        $twig = new Environment($twigLoader);
        $twig->addExtension(new PatternExtension(new CallbackPatternRenderer(function (ViewModel $viewModel) : string {
            return 'foobar';
        })));

        $this->assertSame('foobar', $twig->render('foo', ['bar' => new FlexibleViewModel('/foo', ['bar' => 'baz'])]));
    }
}
