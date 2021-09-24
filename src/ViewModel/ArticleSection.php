<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;
use InvalidArgumentException;

final class ArticleSection implements ViewModel
{
    const STYLE_DEFAULT = 'default';
    const STYLE_ENCLOSED = 'enclosed';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $classes;
    private $id;
    private $doi;
    private $title;
    private $headingLevel;
    private $hasBehaviour;
    private $isInitiallyClosed;
    private $body;
    private $isFirst;
    private $relatedLinks;
    private $headerLink;

    private function __construct(
        string $style = null,
        string $id = null,
        Doi $doi = null,
        Link $headerLink = null,
        string $title,
        int $headingLevel,
        string $body,
        bool $isFirst = false,
        array $relatedLinks = null,
        bool $hasBehaviour = false,
        bool $isInitiallyClosed = false
    ) {
        Assertion::notBlank($title);
        Assertion::nullOrChoice($style, [self::STYLE_DEFAULT, self::STYLE_ENCLOSED]);
        Assertion::min($headingLevel, 2);
        Assertion::max($headingLevel, 6);
        Assertion::notBlank($body);
        Assertion::nullOrNotEmpty($relatedLinks);
        if ($relatedLinks) {
            Assertion::allIsInstanceOf($relatedLinks['items'], Link::class);
        }

        if (null === $id && $doi) {
            throw new InvalidArgumentException('DOI requires an ID');
        }

        if (null !== $doi) {
            $doi = FlexibleViewModel::fromViewModel($doi);
            $doi = $doi->withProperty('variant', Doi::ARTICLE_SECTION);
        }

        if ($style) {
            $this->classes = 'article-section--'.$style;
        }

        $this->id = $id;
        $this->doi = $doi;
        $this->headerLink = $headerLink;
        $this->title = $title;
        $this->headingLevel = $headingLevel;
        $this->hasBehaviour = $hasBehaviour;
        $this->isInitiallyClosed = $isInitiallyClosed;
        $this->body = $body;
        $this->isFirst = $isFirst;
        $this->relatedLinks = $relatedLinks;
    }

    public static function basic(
        string $style = null,
        string $title,
        int $headingLevel,
        string $body,
        $id = null,
        Doi $doi = null,
        bool $isFirst = false,
        Link $headerLink = null,
        array $relatedLinks = null
    ) : ArticleSection {
        return new self($style, $id, $doi, $headerLink, $title, $headingLevel, $body, $isFirst, $relatedLinks);
    }

    public static function collapsible(
        string $style = null,
        string $id,
        string $title,
        int $headingLevel,
        string $body,
        bool $isInitiallyClosed = false,
        bool $isFirst = false,
        Doi $doi = null,
        array $relatedLinks = null
    ) : ArticleSection {
        return new self(
            $style,
            $id,
            $doi,
            null,
            $title,
            $headingLevel,
            $body,
            $isFirst,
            $relatedLinks,
            true,
            $isInitiallyClosed
        );
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/article-section.mustache';
    }
}
