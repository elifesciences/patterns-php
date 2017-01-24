<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

/**
 * @SuppressWarnings(ForbiddenAbleSuffix)
 */
final class Table implements ViewModel, IsCaptioned
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $tables;
    private $hasFootnotes;
    private $footnotes;

    public function __construct(array $tables, array $footnotes = [])
    {
        Assertion::allRegex($tables, '/^<table>[\s\S]+<\/table>$/');
        Assertion::notEmpty($tables);
        Assertion::allIsInstanceOf($footnotes, TableFootnote::class);

        $this->tables = $tables;
        if (!empty($footnotes)) {
            $this->hasFootnotes = true;
            $this->footnotes = $footnotes;
        }
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/table.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/table.css';
    }
}
