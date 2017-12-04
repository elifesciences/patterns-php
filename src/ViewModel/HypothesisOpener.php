<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Exception;
use Traversable;
use function eLife\Patterns\mixed_accessibility_text;

final class HypothesisOpener implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $button;

    /**
     * HypothesisOpener constructor.
     *
     * @param int $annotationCount
     *
     * @throws Exception when $annotationCount is less than 0
     */
    public function __construct(int $annotationCount)
    {
        // TODO: use Assertion::greaterOrEqualThan() once beberlei/assertion updated
        if ($annotationCount < 0) {
            throw new Exception('Annotation count argument must not be less than 0');
        }

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
