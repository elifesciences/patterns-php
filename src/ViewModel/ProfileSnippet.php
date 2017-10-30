<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ProfileSnippet implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $image;
    private $title;
    private $name;

    public function __construct(string $name, string $title, Picture $image = null)
    {
        Assertion::notBlank($name);
        Assertion::notBlank($title);

        $this->name = $name;
        $this->title = $title;
        $this->image = $image;
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/profile-snippet.css';
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/profile-snippet.mustache';
    }
}
