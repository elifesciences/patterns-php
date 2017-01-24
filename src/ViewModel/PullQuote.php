<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class PullQuote implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $quote;
    private $cite;
    private $asPara;

    public function __construct(
        string $quote,
        string $cite = null,
        bool $asPara = true
    ) {
        Assertion::notBlank($quote);

        $this->quote = $quote;
        $this->cite = $cite;
        $this->asPara = $asPara;
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
