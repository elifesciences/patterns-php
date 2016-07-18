<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

class ContentHeaderMagazineArticle implements ViewModel
{

    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    const TITLE_LARGE = 'content-header__title--large';
    const TITLE_MEDIUM = 'content-header__title--medium';
    const TITLE_SMALL = 'content-header__title--small';
    const TITLE_EXTRA_SMALL = 'content-header__title--extra-small';

    const STYLE_BASE = 'content-header-article';
    const STYLE_MAGAZINE = 'content-header-article-magazine';
    const STYLE_MAGAZINE_BACKGROUND = 'content-header-article-magazine--background';
    const STYLE_BACKGROUND_IMAGE = 'content-header--background-image';

    const BEHAVIOUR_BASE = 'ContentHeaderArticle';
    const BEHAVIOUR_BACKGROUND_IMAGE = 'ContentHeaderBackgroundImage';

    const FALLBACK_CLASSES = 'content-header__download_icon'; // @todo check if there are more icons for download.

    private $rootClasses;
    private $behaviour;
    private $title;
    private $titleClass;
    private $strapline;
    private $subject;
    private $articleType;
    private $authors;
    private $institutions;
    private $download;
    private $meta;

    protected function __construct(
        array $rootClasses,
        string $behaviour,
        string $title,
        string $articleType,
        AuthorList $authors,
        string $strapline = null,
        Link $subject = null,
        InstitutionList $institutions = null,
        Picture $download = null,
        Meta $meta = null
    )
    {
        $this->rootClasses = implode(' ', $rootClasses);
        $this->behaviour = $behaviour;
        $this->title = $title;
        $this->titleClass = $this->deriveTitleClass($title);
        $this->strapline = $strapline;
        $this->subject = $subject;
        $this->articleType = $articleType;
        $this->authors = $authors;
        $this->institutions = $institutions;
        $this->download = $this->setDownload($download);
        $this->meta = $meta;
    }

    public static function research(
        string $title,
        string $articleType,
        AuthorList $authors,
        Link $subject = null,
        InstitutionList $institutions = null,
        Picture $download = null,
        Meta $meta = null
    ) {
        // Defaults for research article.
        $rootClasses = [ self::STYLE_BASE ];
        $behaviour = self::BEHAVIOUR_BASE;
        // This can never be set.
        $strapline = null;
        // Constructor.
        return new static(
            $rootClasses,
            $behaviour,
            $title,
            $articleType,
            $authors,
            $strapline,
            $subject,
            $institutions,
            $download,
            $meta
        );
    }

    public static function magazine(
        string $title,
        string $strapline,
        string $articleType,
        AuthorList $authors,
        Picture $download,
        Link $subject = null,
        Meta $meta = null,
        InstitutionList $institutions = null,
        bool $background = false
    ) {
        $rootClasses = [ self::STYLE_BASE, self::STYLE_MAGAZINE ];
        $behaviour = self::BEHAVIOUR_BASE;
        // Can be re-enabled when background image is added.
        // if ($backgroundImage) {
        //     array_push($rootClasses, self::STYLE_BACKGROUND_IMAGE);
        //     array_push($behaviour, self::BEHAVIOUR_BACKGROUND_IMAGE);
        // }
        if ($background) {
            array_push($rootClasses, self::STYLE_MAGAZINE_BACKGROUND);
        }

        // Constructor.
        return new static(
            $rootClasses,
            $behaviour,
            $title,
            $articleType,
            $authors,
            $strapline,
            $subject,
            $institutions,
            $download,
            $meta
        );
    }

    private function setDownload(Picture $picture)
    {
        $picture = FlexibleViewModel::fromViewModel($picture);

        $fallback = $picture['fallback'];
        $fallback['classes'] = static::FALLBACK_CLASSES;

        return $picture
            ->withProperty('fallback', $fallback)
        ;
    }

    protected function deriveTitleClass($title) : string {
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

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/content-header-article.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/content-header-article-magazine.css';
        yield '/elife/patterns/assets/css/content-header-article-research.css';
    }
}
