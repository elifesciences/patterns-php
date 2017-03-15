<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Box implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $id;
    private $label;
    private $title;
    private $headingLevel;
    private $doi;
    private $content;

    public function __construct(string $id = null, string $label = null, string $title, int $headingLevel, Doi $doi = null, string $content)
    {
        Assertion::notBlank($title);
        Assertion::range($headingLevel, 1, 6);
        Assertion::notBlank($content);

        $this->id = $id;
        $this->label = $label;
        $this->title = $title;
        $this->headingLevel = $headingLevel;
        $this->doi = $doi;
        $this->content = $content;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/box.mustache';
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/box.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->doi;
    }
}
