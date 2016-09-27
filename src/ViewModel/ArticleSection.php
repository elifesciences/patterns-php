<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ArticleSection implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $id;
    private $title;
    private $headingLevel;
    private $hasBehaviour;
    private $isInitiallyClosed;
    private $body;
    private $isFirst;

    private function __construct(
        string $id = null,
        string $title,
        int $headingLevel,
        string $body,
        bool $isFirst = false,
        bool $hasBehaviour = false,
        bool $isInitiallyClosed = false
    ) {
        Assertion::notBlank($title);
        Assertion::min($headingLevel, 2);
        Assertion::max($headingLevel, 6);
        Assertion::notBlank($body);

        $this->id = $id;
        $this->title = $title;
        $this->headingLevel = $headingLevel;
        $this->hasBehaviour = $hasBehaviour;
        $this->isInitiallyClosed = $isInitiallyClosed;
        $this->body = $body;
        $this->isFirst = $isFirst;
    }

    public static function basic(
        string $title,
        int $headingLevel,
        string $body,
        $id = null,
        bool $isFirst = false
    ) : ArticleSection {
        return new self($id, $title, $headingLevel, $body, $isFirst);
    }

    public static function collapsible(
        string $id,
        string $title,
        int $headingLevel,
        string $body,
        bool $isInitiallyClosed = false,
        bool $isFirst = false
    ) : ArticleSection {
        return new self($id, $title, $headingLevel, $body, $isFirst, true, $isInitiallyClosed);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/article-section.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/article-section.css';
    }
}
