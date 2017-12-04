<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use function eLife\Patterns\mixed_accessibility_text;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class HypothesisOpener implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $button;

    public function __construct(int $annotationCount)
    {

        Assertion::greaterOrEqualThan($annotationCount, 0);

        $isPopulated = $annotationCount > 0;
        $visibleAnnotationCount = $annotationCount === 0 ? '&#8220;' : strval($annotationCount);
        $text = mixed_accessibility_text(
            $visibleAnnotationCount,
            "Open annotations (there are currently $annotationCount annotations on this page).");
        $this->button = Button::speechBubble($text, true, null, null, $isPopulated);
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
