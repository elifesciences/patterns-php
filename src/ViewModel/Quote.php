<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Quote implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $quote;
    private $cite;

    public function __construct(
        string $quote,
        string $cite = null
    ) {
        Assertion::notBlank($quote);

        $this->quote = $quote;
        $this->cite = $cite;
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/quote.css';
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/quote.mustache';
    }
}
