<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class MediaSource implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $src;
    private $mimeType;
    private $fallback;

    public function __construct(string $src, MimeType $mimeType, MediaSourceFallback $fallback = null)
    {
        Assertion::notBlank($src);

        $this->src = $src;
        $this->mimeType = $mimeType;
        $this->fallback = $fallback;
    }

    public static function audioSource(string $src, string $mediaType, MediaSourceFallback $fallback = null)
    {
        Assertion::regex($mediaType,
            '/^(audio\/[a-zA-Z0-9!#$%^&\*_\-\+{}\|\'.`~]+)(; *[a-zA-Z0-9!#$%^&\*_\-\+{}\|\'.`~]+=(([a-zA-Z0-9\.\-]+)|(".+")))*$/');

        return new static(
            $src,
            new MimeType($mediaType, self::guessHumanType($mediaType)),
            $fallback
        );
    }
    public static function videoSource(string $src, string $mediaType, MediaSourceFallback $fallback = null)
    {
        Assertion::regex($mediaType,
            '/^(video\/[a-zA-Z0-9!#$%^&\*_\-\+{}\|\'.`~]+)(; *[a-zA-Z0-9!#$%^&\*_\-\+{}\|\'.`~]+=(([a-zA-Z0-9\.\-]+)|(".+")))*$/');

        return new static(
            $src,
            new MimeType($mediaType, self::guessHumanType($mediaType)),
            $fallback
        );
    }

    private static function guessHumanType(string $mediaType)
    {
        $parts = explode(';', $mediaType);

        switch ($parts[0]) {
            case 'audio/mp3':
            case 'audio/mpeg':
                return 'MP3';
            case 'audio/ogg':
                return 'OGG';
            case 'audio/webm':
            case 'video/webm':
                return 'WebM';
            case 'video/mp4':
            case 'video/mpeg':
                return 'MP4';
        }

        return $mediaType;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/media-source.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/media-source.css';
    }
}
