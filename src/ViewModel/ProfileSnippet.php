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

    public function __construct(string $name, string $title, Image $image = null)
    {
        Assertion::notBlank($name);
        Assertion::notBlank($title);

        $this->name = $name;
        $this->title = $title;
        if ($image) {
            $this->image = $image->toArray();
            $this->image['classes'] = 'profile-snippet__image';
        }
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/profile-snippet.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/profile-snippet.mustache';
    }
}
