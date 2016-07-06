<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class PullQuote implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $quote;
    private $cite;

    public function __construct(
        string $quote,
        string $cite
    ) {
        Assertion::notBlank($quote);
        Assertion::notBlank($cite);

        $this->quote = $quote;
        $this->cite = $cite;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/pull-quote.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/pull-quote.mustache';
    }
}
