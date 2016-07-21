<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ContentHeaderArticle implements ViewModel
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
    const STYLE_RESEARCH = 'content-header-article-research';
    const STYLE_RESEARCH_READ_MORE = 'content-header-article-research--readmore';
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
    private $subjects;
    private $articleType;
    private $authors;
    private $institutions;
    private $download;
    private $meta;

    private function __construct(
        array $rootClasses,
        string $behaviour,
        string $title,
        string $articleType,
        AuthorList $authors = null,
        string $strapline = null,
        SubjectList $subjects = null,
        InstitutionList $institutions = null,
        Picture $download = null,
        Meta $meta = null
    ) {
        $this->rootClasses = implode(' ', $rootClasses);
        $this->behaviour = $behaviour;
        $this->title = $title;
        $this->titleClass = $this->deriveTitleClass($title);
        $this->strapline = $strapline;
        $this->subjects = $subjects;
        $this->articleType = $articleType;
        $this->authors = $authors;
        $this->institutions = $institutions;
        if ($download) {
            $this->download = $this->setDownload($download);
        }
        $this->meta = $meta;
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

    private function setDownload(Picture $picture)
    {
        $picture = FlexibleViewModel::fromViewModel($picture);

        $fallback = $picture['fallback'];
        $fallback['classes'] = static::FALLBACK_CLASSES;

        return $picture
            ->withProperty('fallback', $fallback);
    }

    public static function researchReadMore(
        string $title,
        string $articleType,
        Meta $meta,
        AuthorList $authors,
        SubjectList $subjects,
        Picture $download = null
    ) {
        if ($authors['hasEtAl'] === false) {
            $authors = AuthorList::readMoreFromList($authors);
        }

        return self::research(
            $title,
            $articleType,
            $authors,
            $meta,
            $subjects,
            null,
            $download
        );
    }

    public static function research(
        string $title,
        string $articleType,
        AuthorList $authors,
        Meta $meta,
        SubjectList $subjects,
        InstitutionList $institutions = null,
        Picture $download = null
    ) {
        // Defaults for research article.
        $rootClasses = [self::STYLE_BASE, self::STYLE_RESEARCH];
        $behaviour = self::BEHAVIOUR_BASE;
        // For read more add the extra class.
        if ($authors['hasEtAl'] === true) {
            array_push($rootClasses, self::STYLE_RESEARCH_READ_MORE);
        }
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
            $subjects,
            $institutions,
            $download,
            $meta
        );
    }

    public static function magazineWithBackground(
        string $title,
        string $strapline,
        string $articleType,
        AuthorList $authors,
        Picture $download = null,
        SubjectList $subjects = null,
        Meta $meta = null,
        InstitutionList $institutions = null
    ) {
        return self::magazine(
            $title,
            $strapline,
            $articleType,
            $authors,
            $download,
            $subjects,
            $meta,
            $institutions,
            true
        );
    }

    public static function magazine(
        string $title,
        string $strapline,
        string $articleType,
        AuthorList $authors,
        Picture $download = null,
        SubjectList $subjects = null,
        Meta $meta = null,
        InstitutionList $institutions = null,
        bool $background = false
    ) {
        $rootClasses = [self::STYLE_BASE, self::STYLE_MAGAZINE];
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
            $subjects,
            $institutions,
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
