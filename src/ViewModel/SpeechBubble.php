<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;
use function eLife\Patterns\mixed_accessibility_text;

final class SpeechBubble implements ViewModel
{
    const DOUBLE_QUOTE_ZERO_SIGNIFIER = '&#8220;';
    const LITERAL_ZERO = '0';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $text;
    private $isSmall;
    private $hasPlaceholder;
    private $behaviour;

    private function __construct(string $zeroSignifier, bool $isSmall = false)
    {
        $visibleAnnotationCount = "<span data-visible-annotation-count>{$zeroSignifier}</span>";
        $hiddenAccessibleText = 'Open annotations (there are currently <span data-hypothesis-annotation-count>0</span> annotations on this page).';
        $this->text = mixed_accessibility_text($visibleAnnotationCount, $hiddenAccessibleText);
        if ($isSmall) {
            $this->isSmall = $isSmall;
        }
        if (self::DOUBLE_QUOTE_ZERO_SIGNIFIER === $zeroSignifier) {
            $this->hasPlaceholder = true;
        }
        $this->behaviour = 'HypothesisOpener';
    }

    public static function forArticleBody() : SpeechBubble
    {
        return new static(self::DOUBLE_QUOTE_ZERO_SIGNIFIER);
    }

    public static function forContextualData() : SpeechBubble
    {
        return new static(self::LITERAL_ZERO, true);
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/speech-bubble.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/speech-bubble.css';
    }
}
