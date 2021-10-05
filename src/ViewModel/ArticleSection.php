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
    const STYLE_HIGHLIGHTED = 'highlighted';

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
    private $relatedLinks;
    private $isFirst;
    private $headerLink;

    private function __construct(
        string $id = null,
        Doi $doi = null,
        Link $headerLink = null,
        string $title,
        int $headingLevel,
        string $body,
        array $relatedLinks = null,
        string $style = null,
        bool $isFirst = false,
        bool $hasBehaviour = false,
        bool $isInitiallyClosed = false
    ) {
        Assertion::notBlank($title);
        Assertion::min($headingLevel, 2);
        Assertion::max($headingLevel, 6);
        Assertion::notBlank($body);
        Assertion::nullOrNotEmpty($relatedLinks);
        if (null !== $relatedLinks) {
            Assertion::allIsInstanceOf($relatedLinks, Link::class);
        }
        Assertion::nullOrChoice($style, [self::STYLE_DEFAULT, self::STYLE_HIGHLIGHTED]);

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
        $this->relatedLinks = $relatedLinks;
        $this->isFirst = $isFirst;
    }

    public static function basic(
        string $title,
        int $headingLevel,
        string $body,
        $id = null,
        Doi $doi = null,
        array $relatedLinks = null,
        string $style = null,
        bool $isFirst = false,
        Link $headerLink = null
    ) : ArticleSection {
        return new self($id, $doi, $headerLink, $title, $headingLevel, $body, $relatedLinks, $style, $isFirst);
    }

    public static function collapsible(
        string $id,
        string $title,
        int $headingLevel,
        string $body,
        array $relatedLinks = null,
        string $style = null,
        bool $isInitiallyClosed = false,
        bool $isFirst = false,
        Doi $doi = null
    ) : ArticleSection {
        return new self(
            $id,
            $doi,
            null,
            $title,
            $headingLevel,
            $body,
            $relatedLinks,
            $style,
            $isFirst,
            true,
            $isInitiallyClosed
        );
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/article-section.mustache';
    }
}
