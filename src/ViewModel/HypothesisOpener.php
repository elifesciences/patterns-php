<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;
use function eLife\Patterns\mixed_accessibility_text;

final class HypothesisOpener implements ViewModel
{
    const DOUBLE_QUOTE_ZERO_SIGNIFIER = '&#8220;';
    const LITERAL_ZERO = '0';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $button;

    private function __construct(string $zeroSignifier, bool $isSmall = false)
    {
        $visibleAnnotationCount = "<span data-visible-annotation-count>{$zeroSignifier}</span>";
        $hiddenAccessibleText = 'Open annotations (there are currently <span data-hypothesis-annotation-count>0</span> annotations on this page).';
        $text = mixed_accessibility_text($visibleAnnotationCount, $hiddenAccessibleText);
        $this->button = Button::speechBubble($text, true, null, null, false, $isSmall);
    }

    public static function forArticleBody() : HypothesisOpener
    {
        return new static(self::DOUBLE_QUOTE_ZERO_SIGNIFIER);
    }

    public static function forContextualData() : HypothesisOpener
    {
        return new static(self::LITERAL_ZERO, true);
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/hypothesis-opener.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/hypothesis-opener.css';
    }
}
