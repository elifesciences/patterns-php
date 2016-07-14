<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

class ContentHeaderArticle implements ViewModel
{

    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    const TITLE_SMALL = 'content-header__title--small';
    const TITLE_EXTRA_SMALL = 'content-header__title--extra-small';

    const STYLE_BASE = 'content-header-article';
    const STYLE_MAGAZINE = 'content-header-article-magazine';
    const STYLE_MAGAZINE_BACKGROUND = 'content-header-article-magazine--background';
    const STYLE_BACKGROUND_IMAGE = 'content-header--background-image';

    const BEHAVIOUR_BASE = 'ContentHeaderArticle';
    const BEHAVIOUR_BACKGROUND_IMAGE = 'ContentHeaderArticle';

    private $rootClasses;
    private $behaviour;
    private $title;
    private $titleClass;
    private $strapline;
    private $subject;
    private $articleType;
    private $authors;
    private $institutions;
    private $backgroundImage;
    private $download;
    private $meta;

    protected function __construct(
        string $rootClasses,
        string $behaviour,
        string $title,
        string $titleClass,
        string $strapline,
        Link $subject,
        string $articleType,
        AuthorList $authors,
        InstitutionList $institutions = null,
        array $backgroundImage = [],
        Picture $download = null,
        Meta $meta = null
    )
    {
        $this->rootClasses = $rootClasses;
        $this->behaviour = $behaviour;
        $this->title = $title;
        $this->titleClass = $titleClass;
        $this->strapline = $strapline;
        $this->subject = $subject;
        $this->articleType = $articleType;
        $this->authors = $authors;
        $this->institutions = $institutions;
        $this->backgroundImage = $backgroundImage;
        $this->download = $download;
        $this->meta = $meta;
    }

    public static function research(
        string $title,
        string $titleClass,
        Link $subject,
        string $articleType,
        AuthorList $authors,
        InstitutionList $institutions = null,
        Picture $download = null,
        Meta $meta = null
    ) {
        $rootClasses = [ self::STYLE_BASE ];
        $behaviour = [ self::BEHAVIOUR_BASE ];
        $strapline = null;
        $backgroundImage = null;

        return new static(
            implode(' ', $rootClasses),
            implode(' ', $behaviour),
            $title,
            $titleClass,
            $strapline,
            $subject,
            $articleType,
            $authors,
            $institutions,
            $backgroundImage,
            $download,
            $meta
        );
    }

    public static function magazine(
        string $title,
        string $titleClass,
        Link $subject,
        string $strapline,
        string $articleType,
        AuthorList $authors,
        Picture $download,
        Meta $meta,
        InstitutionList $institutions = null,
        array $backgroundImage = [],
        bool $background = false
    ) {
        $rootClasses = [ self::STYLE_BASE, self::STYLE_MAGAZINE ];
        $behaviour = [ self::BEHAVIOUR_BASE ];
        if ($backgroundImage) {
            array_push($rootClasses, self::STYLE_BACKGROUND_IMAGE);
            array_push($behaviour, self::BEHAVIOUR_BACKGROUND_IMAGE);
        }
        if ($background) {
            array_push($rootClasses, self::STYLE_MAGAZINE_BACKGROUND);
        }

        return new static(
            implode(' ', $rootClasses),
            implode(' ', $behaviour),
            $title,
            $titleClass,
            $strapline,
            $subject,
            $articleType,
            $authors,
            $institutions,
            $backgroundImage,
            $download,
            $meta
        );
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
