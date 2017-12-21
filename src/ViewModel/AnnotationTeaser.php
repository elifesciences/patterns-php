<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class AnnotationTeaser implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    const RESTRICTED_ACCESS = true;
    const RESTRICTED_ACCESS_TEXT = 'Only me';

    private $content;
    private $document;
    private $highlight;
    private $isReply;
    private $meta;
    private $url;

    private function __construct(
        string $document,
        Date $date,
        string $url,
        string $highlight = null,
        string $content = null,
        bool $isRestrictedAccess = false,
        bool $isReply = false
    ) {
        Assertion::notEmpty($document);
        Assertion::notNull($date);
        Assertion::notEmpty($url);

        $this->document = $document;
        $this->url = $url;
        $this->isReply = $isReply;

        if ($highlight) {
            $this->highlight = $highlight;
        }

        if ($content) {
            $this->content = $content;
        }

        if ($isRestrictedAccess) {
            $this->meta = Meta::withText(self::RESTRICTED_ACCESS_TEXT, $date);
        } else {
            $this->meta = Meta::withDate($date);
        }
    }

    public static function full(
        string $document,
        Date $date = null,
        string $url = '',
        string $highlight = '',
        string $content = '',
        bool $isRestricted = false
    ) : AnnotationTeaser {
        Assertion::notEmpty($highlight);
        Assertion::notEmpty($content);

        return new static(
            $document,
            $date,
            $url,
            $highlight,
            $content,
            $isRestricted
        );
    }

    public static function highlight(
        string $document,
        Date $date,
        string $url,
        string $highlight,
        bool $isRestricted = false

    ) : AnnotationTeaser {
        Assertion::notBlank($highlight);

        return new static(
            $document,
            $date,
            $url,
            $highlight,
            null,
            $isRestricted
        );
    }

    public static function pageNote(
        string $document,
        Date $date,
        string $url,
        string $content,
        bool $isRestricted = false
    ) : AnnotationTeaser {
        Assertion::notBlank($content);

        return new static(
            $document,
            $date,
            $url,
            null,
            $content,
            $isRestricted
        );
    }

    public static function reply(
        string $document,
        Date $date = null,
        string $url,
        string $content,
        bool $isRestricted = false
    ) : AnnotationTeaser {
        Assertion::notBlank($content);

        return new static(
            $document,
            $date,
            $url,
            null,
            $content,
            $isRestricted,
            true
        );
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/annotation-teaser.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/annotation-teaser.css';
    }
}
