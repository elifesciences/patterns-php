<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class HypothesisOpener implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $button;

    public function __construct(Button $button)
    {
        Assertion::notNull($button);

        $this->button = $button;
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
