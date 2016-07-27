<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class PodcastDownload implements CastsToArray, IsImage
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $downloadLink;
    private $fallback;
    private $sources;
    private $picture;

    const STYLE_DOWNLOAD_ICON = 'content-header__download_icon';

    public function __construct(string $downloadLink, Picture $picture, string $style = null)
    {
        Assertion::notBlank($downloadLink);
        if ($style) {
            Assertion::inArray($style, [ self::STYLE_DOWNLOAD_ICON ]);
        }
        
        $this->picture = $this->setPicture($picture);
        $this->downloadLink = $downloadLink;
    }

    private function setPicture(Picture $picture)
    {
        $picture = FlexibleViewModel::fromViewModel($picture);

        $fallback = $picture['fallback'];
        $fallback['classes'] = static::STYLE_DOWNLOAD_ICON;

        return $picture
            ->withProperty('fallback', $fallback);
    }

    private function fallbackFromPicture(Picture $source)
    {
        $picture = $source->toArray();
        $fallback = $picture['fallback'];
        // Split into classes.
        $classes = explode(' ', $fallback['classes'] ?? '') ?? [];
        // Push our new one.
        array_push($classes, 'content-header__download_icon');
        // Make sure unique.
        $classes = array_unique($classes);
        // Glue back together.
        $fallback['classes'] = implode(' ', $classes);

        return $fallback;
    }
}
