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
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $button;

    public function __construct()
    {
        $visibleAnnotationCount = '<span data-visible-annotation-count>&#8220;</span>';
        $hiddenAccessibleText = 'Open annotations (there are currently <span data-hypothesis-annotation-count>0</span> annotations on this page).';
        $text = mixed_accessibility_text($visibleAnnotationCount, $hiddenAccessibleText);
        $this->button = Button::speechBubble($text, true, null, null, false);
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
