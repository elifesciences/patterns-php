<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class ProfileSnippet implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

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

    private function setPicture(Picture $picture)
    {
        $picture = FlexibleViewModel::fromViewModel($picture);

        $fallback = $picture['fallback'];
        $fallback['classes'] = static::FALLBACK_CLASSES;

        $this->picture = $picture
            ->withProperty('pictureClasses', self::PICTURE_CLASSES)
            ->withProperty('fallback', $fallback)
        ;
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/profile-snippet.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/profile-snippet.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->picture;
    }
}
