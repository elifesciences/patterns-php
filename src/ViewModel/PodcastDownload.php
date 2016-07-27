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

    public function __construct(string $downloadLink, Picture $picture)
    {
        Assertion::notBlank($downloadLink);

        $this->downloadLink = $downloadLink;
        $this->fallback = $this->fallbackFromPicture($picture);
        $this->sources = $picture['sources'];
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
