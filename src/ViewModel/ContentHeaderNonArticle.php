<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use tests\eLife\Patterns\ViewModel\Profile;
use Traversable;

final class ContentHeaderNonArticle implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    const STYLE_BASE = 'content-header-nonarticle';
    const STYLE_BACKGROUND = 'content-header-nonarticle--background';

    const TITLE_LARGE = 'content-header__title--large';
    const TITLE_MEDIUM = 'content-header__title--medium';
    const TITLE_SMALL = 'content-header__title--small';
    const TITLE_EXTRA_SMALL = 'content-header__title--extra-small';

    const BEHAVIOUR_SELECT_NAV = 'ContentHeaderSelectNav';

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

    protected function __construct(
        array $rootClasses,
        array $behaviour,
        string $title,
        string $strapline = null,
        Button $button = null,
        Meta $meta = null,
        Profile $profile = null,
        SelectNav $selectNav = null
    ) {
        Assertion::allInArray($rootClasses, [self::STYLE_BASE, self::STYLE_BACKGROUND]);
        Assertion::allInArray($behaviour, [self::BEHAVIOUR_SELECT_NAV]);
        Assertion::notBlank($title);

        $this->rootClasses = implode(' ', $rootClasses);
        $this->behaviour = implode(' ', $behaviour);
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
    }

    private function deriveTitleClass($title) : string
    {
        $titleLength = strlen($title);
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
        Meta $meta = null
    ) {
        $rootClasses = [self::STYLE_BASE];
        if ($background) {
            array_push($rootClasses, self::STYLE_BACKGROUND);
        }

        return new static(
            $rootClasses,
            [],
            $title,
            $strapline,
            $button,
            $meta
        );
    }

    public static function curatedContentListing(
        string $title,
        bool $background = false,
        string $strapline = null,
        Button $button = null,
        Meta $meta = null,
        Profile $profile = null
    ) {
        $rootClasses = [self::STYLE_BASE];
        $behaviours = [self::BEHAVIOUR_SELECT_NAV];
        if ($background) {
            array_push($rootClasses, self::STYLE_BACKGROUND);
        }

        return new static (
            $rootClasses,
            $behaviours,
            $title,
            $strapline,
            $button,
            $meta,
            $profile
        );
    }

    public static function podcast(
        string $title,
        bool $background = false,
        string $strapline = null,
        Button $button = null,
        Meta $meta = null
    ) {
        $rootClasses = [self::STYLE_BASE];
        $behaviours = [self::BEHAVIOUR_SELECT_NAV];
        if ($background) {
            array_push($rootClasses, self::STYLE_BACKGROUND);
        }

        return new static (
            $rootClasses,
            $behaviours,
            $title,
            $strapline,
            $button,
            $meta
        );
    }

    public static function subject(
        string $title,
        bool $background = false,
        Button $button = null
    ) {
        $rootClasses = [self::STYLE_BASE];
        $behaviours = [self::BEHAVIOUR_SELECT_NAV];
        $strapline = null;
        if ($background) {
            array_push($rootClasses, self::STYLE_BACKGROUND);
        }

        return new static (
            $rootClasses,
            $behaviours,
            $title,
            $strapline,
            $button
        );
    }

    public static function archive(
        string $title,
        bool $background,
        SelectNav $selectNav
    ) {
        $rootClasses = [self::STYLE_BASE];
        $behaviours = [self::BEHAVIOUR_SELECT_NAV];
        $strapline = null;
        $profile = null;
        $button = null;
        $meta = null;
        if ($background) {
            array_push($rootClasses, self::STYLE_BACKGROUND);
        }

        return new static (
            $rootClasses,
            $behaviours,
            $title,
            $strapline,
            $button,
            $meta,
            $profile,
            $selectNav
        );
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/content-header-non-article.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/content-header-non-article.css';
    }
}
