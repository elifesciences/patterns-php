<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class Box implements ViewModel
{
    use ArrayFromProperties;
    use ComposedAssets;
    use ReadOnlyArrayAccess;

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
        return '/elife/patterns/templates/box.mustache';
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/box.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->doi;
    }
}