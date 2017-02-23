<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ContentHeaderReadMore implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    const TITLE_LARGE = 'content-header__title--large';
    const TITLE_MEDIUM = 'content-header__title--medium';
    const TITLE_SMALL = 'content-header__title--small';
    const TITLE_EXTRA_SMALL = 'content-header__title--extra-small';

    const BEHAVIOUR_BASE = 'ContentHeaderArticle';
    const BEHAVIOUR_BACKGROUND_IMAGE = 'BackgroundImage';

    const FALLBACK_CLASSES = 'content-header__download_icon'; // @todo check if there are more icons for download.

    private $behaviour;
    private $title;
    private $url;
    private $titleClass;
    private $strapline;
    private $subjects;
    private $authorLine;
    private $meta;

    public function __construct(
        string $title,
        string $url,
        string $strapline = null,
        string $authorLine = null,
        SubjectList $subjects = null,
        Meta $meta = null
    ) {
        $behaviours = [self::BEHAVIOUR_BASE];

        $this->behaviour = implode(' ', $behaviours);
        $this->title = $title;
        $this->url = $url;
        $this->titleClass = $this->deriveTitleClass($title);
        $this->strapline = $strapline;
        $this->subjects = $subjects;
        $this->authorLine = $authorLine;
        $this->meta = $meta;
    }

    private function deriveTitleClass($title): string
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

    public function getTemplateName(): string
    {
        return '/elife/patterns/templates/content-header-read-more.mustache';
    }

    protected function getLocalStyleSheets(): Traversable
    {
        yield '/elife/patterns/assets/css/content-header-article-research.css';
    }

    protected function getComposedViewModels(): Traversable
    {
        yield $this->meta;
    }
}
