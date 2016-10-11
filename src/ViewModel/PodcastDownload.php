<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\HasAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use Traversable;

final class PodcastDownload implements CastsToArray, IsCaptioned, HasAssets
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    private $downloadLink;
    private $fallback;
    private $sources;
    private $picture;

    const STYLE_DOWNLOAD_ICON = 'content-header__download_icon';

    public function __construct(string $downloadLink, Picture $picture, string $style = null)
    {
        Assertion::notBlank($downloadLink);
        if ($style) {
            Assertion::inArray($style, [self::STYLE_DOWNLOAD_ICON]);
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

    protected function getComposedViewModels() : Traversable
    {
        yield $this->picture;
    }
}
