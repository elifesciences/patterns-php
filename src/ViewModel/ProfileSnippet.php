<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

class ProfileSnippet implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    const FALLBACK_CLASSES = 'profile-snippet__image';
    const PICTURE_CLASSES = 'profile-snippet__picture';

    private $picture;
    private $title;
    private $name;

    public function __construct(string $name, string $title, Picture $picture)
    {
        Assertion::notBlank($name);
        Assertion::notBlank($title);
        
        $this->name = $name;
        $this->title = $title;
        $this->setPicture($picture);
    }

    protected function setPicture(Picture $picture) {
        $this->picture = $picture
            ->addPictureClass(static::PICTURE_CLASSES)
            ->addFallbackClass(static::FALLBACK_CLASSES)
        ;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/profile-snippet.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/profile-snippet.mustache';
    }
}
