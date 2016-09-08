<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class ContentHeaderNonArticle implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    const STYLE_BASE = 'content-header-nonarticle';
    const STYLE_BACKGROUND = 'content-header-nonarticle--background';

    const TITLE_LARGE = 'content-header__title--large';
    const TITLE_MEDIUM = 'content-header__title--medium';
    const TITLE_SMALL = 'content-header__title--small';
    const TITLE_EXTRA_SMALL = 'content-header__title--extra-small';

    const BEHAVIOUR_SELECT_NAV = 'ContentHeaderSelectNav';
    const BEHAVIOUR_BACKGROUND_IMAGE = 'BackgroundImage';

    private $rootClasses;
    private $title;
    private $titleClass;
    private $strapline;
    private $behaviour;
    private $button;
    private $meta;
    private $hasCtaOrMeta = false;
    private $profile;
    private $hasProfile = false;
    private $selectNav;
    private $backgroundImage;
    private $download;

    protected function __construct(
        array $rootClasses,
        string $title,
        string $strapline = null,
        Button $button = null,
        Meta $meta = null,
        Profile $profile = null,
        SelectNav $selectNav = null,
        BackgroundImage $backgroundImage = null,
        PodcastDownload $podcastDownload = null
    ) {
        Assertion::allInArray($rootClasses, [self::STYLE_BASE, self::STYLE_BACKGROUND]);
        Assertion::notBlank($title);

        $behaviours = [];
        if ($backgroundImage) {
            array_push($behaviours, self::BEHAVIOUR_BACKGROUND_IMAGE);
        }
        if ($selectNav) {
            array_push($behaviours, self::BEHAVIOUR_SELECT_NAV);
        }

        $this->rootClasses = implode(' ', $rootClasses);
        $this->behaviour = implode(' ', $behaviours);
        $this->title = $title;
        $this->titleClass = $this->deriveTitleClass($title);
        $this->strapline = $strapline;
        if ($button) {
            $this->button = $button;
        }
        $this->meta = $meta;
        if ($profile) {
            $this->hasProfile = true;
            $this->profile = $profile;
        }
        $this->selectNav = $selectNav;
        if ($meta || $button || $selectNav) {
            $this->hasCtaOrMeta = true;
        }
        $this->backgroundImage = $backgroundImage;
        $this->download = $podcastDownload;
    }

    private function deriveTitleClass($title) : string
    {
        $titleLength = strlen(strip_tags($title));

        if ($titleLength >= 80) {
            return self::TITLE_EXTRA_SMALL;
        }
        if ($titleLength >= 60) {
            return self::TITLE_SMALL;
        }
        if ($titleLength >= 30) {
            return self::TITLE_MEDIUM;
        }

        return self::TITLE_LARGE;
    }

    public static function basic(
        string $title,
        bool $background = false,
        string $strapline = null,
        Button $button = null,
        Meta $meta = null,
        BackgroundImage $backgroundImage = null
    ) {
        $rootClasses = [self::STYLE_BASE];
        if ($background || $backgroundImage) {
            array_push($rootClasses, self::STYLE_BACKGROUND);
        }

        return new static(
            $rootClasses,
            $title,
            $strapline,
            $button,
            $meta,
            null,
            null,
            $backgroundImage
        );
    }

    public static function curatedContentListing(
        string $title,
        bool $background,
        string $strapline = null,
        Button $button = null,
        Meta $meta = null,
        Profile $profile = null,
        BackgroundImage $backgroundImage
    ) {
        $rootClasses = [self::STYLE_BASE];
        if ($background || $backgroundImage) {
            array_push($rootClasses, self::STYLE_BACKGROUND);
        }

        return new static (
            $rootClasses,
            $title,
            $strapline,
            $button,
            $meta,
            $profile,
            null,
            $backgroundImage
        );
    }

    public static function podcast(
        string $title,
        bool $background = false,
        string $strapline = null,
        Button $button = null,
        Meta $meta = null,
        BackgroundImage $backgroundImage = null,
        PodcastDownload $podcastDownload = null
    ) {
        $rootClasses = [self::STYLE_BASE];
        if ($background || $backgroundImage) {
            array_push($rootClasses, self::STYLE_BACKGROUND);
        }

        return new static (
            $rootClasses,
            $title,
            $strapline,
            $button,
            $meta,
            null,
            null,
            $backgroundImage,
            $podcastDownload
        );
    }

    public static function subject(
        string $title,
        bool $background = false,
        Button $button = null,
        BackgroundImage $backgroundImage = null
    ) {
        $rootClasses = [self::STYLE_BASE];
        $strapline = null;
        if ($background || $backgroundImage) {
            array_push($rootClasses, self::STYLE_BACKGROUND);
        }

        return new static (
            $rootClasses,
            $title,
            $strapline,
            $button,
            null,
            null,
            null,
            $backgroundImage
        );
    }

    public static function archive(
        string $title,
        bool $background,
        SelectNav $selectNav,
        BackgroundImage $backgroundImage = null
    ) {
        $rootClasses = [self::STYLE_BASE];
        $strapline = null;
        $profile = null;
        $button = null;
        $meta = null;
        if ($background || $backgroundImage) {
            array_push($rootClasses, self::STYLE_BACKGROUND);
        }

        return new static (
            $rootClasses,
            $title,
            $strapline,
            $button,
            $meta,
            $profile,
            $selectNav,
            $backgroundImage
        );
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/content-header-non-article.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/content-header-non-article.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->meta;
        yield $this->selectNav;
        yield $this->button;
        yield $this->download;
    }
}
